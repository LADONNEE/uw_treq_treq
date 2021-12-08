<?php

namespace App\Http\Controllers;

use App\Workflows\OrderTypes as WorkflowOrderTypes;
use App\Workflows\Templates\TemplateFactory;
use Illuminate\Support\Str;

class Workflows extends Controller
{
    private $names = [];
    public function __invoke()
    {
        $types = (new WorkflowOrderTypes())->types;
        $tf = new TemplateFactory();
        $workflows = [];

        foreach ($types as $type) {
            $t = $tf->get($type->slug);
            $workflows[$type->slug] = [
                'request-steps' => $t->requestSteps(),
                'process-steps' => $this->processStepNames($t->taskSteps()),
            ];
        }

        return view('workflows.index', compact('types', 'workflows'));
    }

    private function processStepNames(array $classNames)
    {
        $out = [];
        foreach ($classNames as $className) {
            $out[] = $this->nameOfClass($className);
        }
        return $out;
    }

    private function nameOfClass($fqClassName)
    {
        if (isset($this->names[$fqClassName])) {
            return $this->names[$fqClassName];
        }

        $name = str_replace('App\\Workflows\\TaskSteps\\', '', $fqClassName);
        $name = Str::snake($name);
        $name = str_replace('_', ' ', $name);
        $this->names[$fqClassName] = ucwords($name);

        return $this->names[$fqClassName];
    }
}
