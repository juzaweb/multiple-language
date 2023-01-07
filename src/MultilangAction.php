<?php

namespace Juzaweb\Multilang;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Language;

class MultilangAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addBackendMenu']);
        //$this->addAction(Action::POSTS_FORM_RIGHT_ACTION, [$this, 'addSelectLangPost'], 5);
        $this->addAction(Action::INIT_ACTION, [$this, 'addConfigs']);
    }
    
    public function addBackendMenu()
    {
        HookAction::addAdminMenu(
            trans('multilang::content.multi_language'),
            'multi_language',
            [
                'icon' => 'fa fa-language',
                'position' => 50,
            ]
        );
        
        HookAction::registerAdminPage(
            'languages',
            [
                'title' => trans('cms::app.language'),
                'menu' => [
                    'position' => 10,
                    'parent' => 'managements',
                ],
            ]
        );
        
        HookAction::registerAdminPage(
            'multi-language.setting',
            [
                'title' => trans('cms::app.setting'),
                'menu' => [
                    'icon' => 'fa fa-cog',
                    'position' => 3,
                    'parent' => 'multi_language',
                ],
            ]
        );
    }
    
    public function addSelectLangPost($model)
    {
        $default = get_config('language', 'en');
        $selected = $default;
        $languages = Language::get()->mapWithKeys(
            function ($item) {
                return [
                    $item->code => $item->name,
                ];
            }
        );
        
        echo e(
            view(
                'multilang::select_lang',
                compact(
                    'model',
                    'languages',
                    'selected'
                )
            )
        );
    }
    
    public function addConfigs()
    {
        HookAction::registerConfig(['mlla_type', 'mlla_subdomain']);
    }
}
