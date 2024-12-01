<?php

namespace Kaneki\Diverse\PagingQuery;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use KanekiYuto\Handy\Support\Facades\Preacher;
use KanekiYuto\Handy\Preacher\PreacherResponse;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * 分页查询 - [Paging]
 *
 * @todo   后续重构此类
 * @author KanekiYuto
 */
class PagingQuery
{

	/**
	 * 分页查询参数标记
	 *
	 * @var string
	 */
	const PAGING_PARAMS_MARK = 'query_';

	/**
	 * 请求参数逻辑整合
	 *
	 * @param  Request  $request
	 * @param  string   $class
	 * @param  string   $method
	 * @param  array    $orderBy
	 * @param  array    $queryRule
	 *
	 * @return PreacherResponse
	 */
	public static function request(
		Request $request,
		string $class,
		string $method = 'paging',
		array $orderBy = ['id'],
		array $queryRule = []
	): PreacherResponse {
		// 验证请求参数
		$requestParams = $request::validate(array_merge([
			'page' => ['required', 'integer'],
			'prePage' => ['required', 'integer'],
			'orderBy' => ['required', Rule::in($orderBy)],
			'order' => ['required', Rule::in(['asc', 'desc'])],
		], self::pagingParamsEncode($queryRule)));

		// 回调对应的服务类方法
		$callback = call_user_func(
			[$class, $method],
			$requestParams['page'],
			$requestParams['prePage'],
			$requestParams['orderBy'],
			$requestParams['order'],
			self::pagingParamsDecode($requestParams)
		);

		if ($callback === false) {
			return Preacher::msgCode(
				PreacherResponse::RESP_CODE_FAIL,
				'回调函数不存在'
			);
		}

		return $callback;
	}

	/**
	 * 为分页查询参数编码（加上数组键前缀）
	 *
	 * @param  array  $params
	 *
	 * @return array
	 */
	private static function pagingParamsEncode(array $params): array
	{
		return array_combine(
			array_map(function (string|int $key) {
				return self::PAGING_PARAMS_MARK.$key;
			}, array_keys($params)),
			$params
		);
	}

	/**
	 * 为分页查询参数解码（解除数组键前缀）
	 *
	 * @param  array  $params
	 *
	 * @return array
	 */
	private static function pagingParamsDecode(array $params): array
	{
		$pagingParamsMarkLen = mb_strlen(self::PAGING_PARAMS_MARK);

		// 先过滤无关参数
		$params = array_filter($params, function (string $key) use ($pagingParamsMarkLen) {
			return substr($key, 0, $pagingParamsMarkLen) === self::PAGING_PARAMS_MARK;
		}, ARRAY_FILTER_USE_KEY);

		// 重新生成数组键
		return array_combine(
			array_map(function (string|int $key) use ($pagingParamsMarkLen) {
				// 移除前缀字符
				return substr(
					$key,
					$pagingParamsMarkLen,
					mb_strlen($key) - $pagingParamsMarkLen
				);
			}, array_keys($params)),
			$params
		);
	}

	/**
	 * 响应逻辑整合
	 *
	 * @param  EloquentBuilder|QueryBuilder  $model
	 * @param  int                           $page
	 * @param  int                           $prePage
	 * @param  string                        $oderBy
	 * @param  string                        $order
	 * @param  array                         $columns
	 * @param  callable|null                 $callback
	 *
	 * @return PreacherResponse
	 */
	public static function response(
		EloquentBuilder|QueryBuilder $model,
		int $page,
		int $prePage,
		string $oderBy,
		string $order,
		array $columns = ['*'],
		callable $callback = null
	): PreacherResponse {
		$model->orderBy($oderBy, $order);

		// 分頁信息設置
		$model = $model->paginate(
			perPage: $prePage,
			columns: $columns,
			page: $page,
		);

		$items = $model->items();

		if (is_callable($callback)) {
			$items = call_user_func($items);
		}

		return Preacher::paging(
			$model->currentPage(),
			$model->perPage(),
			$model->total(),
			$items
		);
	}

}
