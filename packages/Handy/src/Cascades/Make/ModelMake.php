<?php

namespace KanekiYuto\Handy\Cascades\Make;

use Illuminate\Support\Str;
use KanekiYuto\Handy\Cascades\Builder;
use KanekiYuto\Handy\Cascades\Constants\CascadeConst;
use function Laravel\Prompts\note;
use function Laravel\Prompts\error;

/**
 * 构建 - [Model]
 *
 * @author KanekiYuto
 */
class ModelMake extends Make
{

	private array $casts = [];

	/**
	 * 引导构建
	 *
	 * @return void
	 */
	public function boot(): void
	{
		parent::boot();

		note('开始创建 Model...');

		$stubsDisk = Builder::useDisk(Builder::getStubsPath());
		$this->load($stubsDisk->get('model.base.stub'));

		if (empty($this->stub)) {
			error('创建失败...存根无效或不存在...');
			return;
		}

		$blueprint = $this->blueprint;
		$table = $blueprint->getTable();
		$className = $this->getClassName($table, CascadeConst::MODEL_FILE_SUFFIX);
		$namespace = $this->getNamespace($table, [
			CascadeConst::MODEL_NAMESPACE,
		]);

		// Do it...
		$this->param('namespace', implode(CascadeConst::NAMESPACE_SEPARATOR, [
			CascadeConst::APP_NAMESPACE,
			$namespace,
		]));

		$this->param('class', $className);
		$this->param('usePackage', '');
		$this->param('useTrait', $this->useTrait());
		$this->param('comment', $blueprint->getComment());

		$this->param('traceEloquent', $this->getPackage($table, [
			CascadeConst::TRACE_NAMESPACE,
			CascadeConst::TRACE_ELOQUENT_NAMESPACE,
		], CascadeConst::TRACE_NAMESPACE));

		$this->param('table', $table);
		$this->param('timestamps', false);
		$this->param('incrementing', false);

		$this->columns();
		$this->param('casts', $this->casts());

		var_dump($this->casts);

		$this->stub = $this->formattingStub($this->stub);
		$this->putFile($namespace, $className);
	}

	/**
	 * 使用 [trait]
	 *
	 * @return string
	 */
	private function useTrait(): string
	{
		return '';
	}

	private function columns(): void
	{
		$columns = $this->blueprint->getColumns();

		foreach ($columns as $column) {
			$columnDefinition = $column->getColumnParams();
			$cast = $columnDefinition->getCast();

			$field = $columnDefinition->getField();
			$constantCode = Str::of($field)->upper()->toString();

			if (!empty($cast)) {
				$this->casts["TheTrace::$constantCode"] = $cast;
			}
		}
	}

	/**
	 * 处理强制转换的属性
	 *
	 * @return string
	 */
	private function casts(): string
	{
		if (empty($this->casts)) {
			return 'return [];';
		}

		$template[] = 'return [';

		$casts = collect($this->casts)->map(function (string $value, string $key) {
			return "\t$key => '$value',";
		})->all();

		$template = array_merge($template, $casts);
		$template[] = '];';

		return implode("\n\t\t", $template);
	}

}
