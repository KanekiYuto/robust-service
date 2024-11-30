<?php

namespace KanekiYuto\Handy\Cascades\Make;

use KanekiYuto\Handy\Cascades\Builder;
use KanekiYuto\Handy\Cascades\Constants\CascadeConst;
use function Laravel\Prompts\error;
use function Laravel\Prompts\note;

/**
 * 构建 - [Model]
 *
 * @author KanekiYuto
 */
class ModelMake extends Make
{

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
            CascadeConst::MODEL_NAMESPACE
        ]);

        // Do it...
        $this->param('namespace', implode(CascadeConst::NAMESPACE_SEPARATOR, [
            CascadeConst::APP_NAMESPACE,
            $namespace
        ]));

        $this->param('class', $className);
        $this->param('usePackage', '');
        $this->param('useTrait', $this->useTrait());
        $this->param('comment', $blueprint->getComment());

        $this->param('traceEloquent', $this->getPackage($table, [
            CascadeConst::TRACE_NAMESPACE,
            CascadeConst::TRACE_ELOQUENT_NAMESPACE
        ], CascadeConst::TRACE_NAMESPACE));

        $this->param('table', $table);
        $this->param('timestamps', false);
        $this->param('incrementing', false);

        $this->putFile($namespace, $className);
    }

    /**
     * 使用 [trait]
     *
     * @return string
     */
    private function useTrait(): string
    {
        return 'use Test;';
    }

}
