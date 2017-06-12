<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\View\CellTrait;
use Cake\Routing\Router;

/**
 * Main Controller
 *
 * @property \App\Model\Table\UsersTable $Main
 */
class MainController extends AppController
{
    public $helpers = ['NavigationSelector'];

    use CellTrait;

    /**
     * Initialize Method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["home"];
        $this->set('nav_selected', $nav_selected);
        $this->set('website_title', 'Nixser Online Services');
        $this->set('page_title', 'Home');
    }    
    
    /**
     * BeforeFilter Method
     *  ID : CA-02
     * 
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index','filter']);
    }

    /**
     * Index method for homepage
     *  ID : CA-03
     * @return void
     */

    public function index()
    {
        $this->Pages  = TableRegistry::get('Pages');
        $this->Slides = TableRegistry::get('Slides');

        $page = $this->Pages->find()
            ->where([
                'Pages.title' => 'Home'
            ])
            ->first();

        $slides = $this->Slides->find('all')
            ->where([
                'Slides.is_publish' => 1
            ])
            ->order(['Slides.sorting' => 'ASC']);

        $this->set(['page' => $page, 'slides' => $slides]);

        $this->viewBuilder()->layout('main');        
    }

    /**
     * Index method for homepage
     *  ID : CA-04
     * @return void
     */

    public function filter()
    {
        $this->Versions    = TableRegistry::get('Versions');
        $this->ModuleTypes = TableRegistry::get('ModuleTypes');

        $mods    = $this->ModuleTypes->find('all');
        $modules = array();
        $modules[0] = 'All';
        foreach( $mods as $mod ){
            $modules[$mod->id] = $mod->name;
        }

        $query = $this->request->query;
        if( isset($query['module_type']) && $query['module_type'] != '' ){
            switch ($query['module_type']) {
                case 0:
                    $versions = $this->Versions->find('all')
                        ->contain(['ModuleTypes'])
                        ->order(['Versions.version' => 'DESC']);        
                    break;
                default:
                    $versions = $this->Versions->find('all')
                        ->contain(['ModuleTypes'])
                        ->where(['Versions.module_type_id' => $query['module_type']])     
                        ->order(['Versions.version' => 'DESC']);               
                    break;
            }  
        }else{
            $versions = $this->Versions->find('all')
                ->contain(['ModuleTypes'])              
                ->order(['Versions.version' => 'DESC']);              
        }

        $this->set(['versions' => $versions, 'modules' => $modules]);
        $this->layout = "main";
    }

}
