<?php

namespace Database\Seeders;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Cascade\Models\Admin\AbilityModel;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;

/**
 * 管理员能力填充
 *
 * @author KanekiYuto
 */
class AdminAbilitySeeder extends Seeder
{

	public array $params = [];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void
	{
		$uuid = Str::uuid()->toString();

		$this->ability(
			name: '管理员相关',
			parentUuid: $uuid,
			children: function (string $uuid) {
				$this->ability(
					name: '信息相关',
					parentUuid: $uuid,
					children: function (string $uuid) {
						$this->ability(name: '新增', parentUuid: $uuid, serverRouting: [
							'backstage.admin.info:append',
						], operation: [
							'admin-info-append' => 'button',
						], type: 'ability');

						$this->ability(name: '查询', parentUuid: $uuid, clientRouting: [
							'admin-info-manage',
						], serverRouting: [
							'backstage.admin.info:paging',
						], type: 'ability');

						$this->ability(name: '修改', parentUuid: $uuid, serverRouting: [
							'backstage.admin.info:modify',
							'backstage.admin.role:select',
						], operation: [
							'admin-info-modify' => 'button',
						], type: 'ability');
					}
				);
			}
		);

//		$json = json_encode($this->params, JSON_UNESCAPED_UNICODE);
//		$json = Str::of($json)->replace(',', ",\n")->toString();
//
//		echo $json . "\n";

		collect($this->params)->map(function (array $params) {
			$save = AbilityModel::query()->create($params)->save();

			var_dump($save);
		});
	}

	private function ability(
		string $name,
		string $parentUuid,
		Closure $children = null,
		array $clientRouting = [],
		array $serverRouting = [],
		array $operation = [],
		string $type = 'group',
	): void {
		$currentUuid = Str::uuid()->toString();

		$this->params[] = [
			AbilityTrace::NAME => $name,
			AbilityTrace::CURRENT_UUID => $currentUuid,
			AbilityTrace::PARENT_UUID => $parentUuid,
			AbilityTrace::CLIENT_ROUTING => $clientRouting,
			AbilityTrace::SERVER_ROUTING => $serverRouting,
			AbilityTrace::OPERATION => $operation,
			AbilityTrace::TYPE => $type,
		];

		if (!is_null($children)) {
			$children($currentUuid);
		}
	}

}
