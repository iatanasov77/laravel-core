<?php namespace IA\LaravelCore\CRUD;

use Illuminate\Console\Command;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;

class CreateResourceCommand extends Command
{
    use ModuleCommandTrait;
    
    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'resource';
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orm:resource:create-controller';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new resource classes and configuration.';
    
    public function handle()
    {
        $this->createConfig();
        $this->createModel();
        $this->createViews();
        $this->createRequest();
        $this->createController();
        
        $this->info( "DONE !" );
    }
    
    public function getDefaultNamespace() : string
    {
        return $this->laravel['modules']->config('paths.generator.controller.path', 'Http/Controllers');
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    protected function createConfig()
    {
        $configPath     = $this->laravel['modules']->getModulePath( $this->getModuleName() ) . 'Config/config.php';
        $config         = require $configPath;
        
        $config['resources'][$this->argument( 'resource' ) . 's']    = [
            'entityType'    => '\\Modules\\' .  $this->getModuleName() . '\\Entities\\User',
            'viewNamespace' => 'admin.modules.user_management.users',
            'routePath'     => '/admin/user-management/users',
            'requestClass'  => '\\Modules\\' .  $this->getModuleName() . '\\Http\\Requests\\UsersRequest'
        ];
        
        $this->filesystem->put( $configPath, json_encode( $config, true ) );
    }
    
    protected function createModel()
    {
        
    }
    
    protected function createViews()
    {
        
    }
    
    protected function createRequest()
    {
        
    }
    
    /**
     * @return string
     */
    protected function createController()
    {
        $module = $this->laravel['modules']->findOrFail( $this->getModuleName() );
        $path = str_replace( '\\', '/', $this->getControllerPath() );
        
        try 
        {
            $contents   = ( new Stub( '/controller.stub', [
                'CLASS_NAMESPACE'   => '\\Modules\\' . $this->getModuleName() . '\\Controllers',
                'CLASS'             => $this->getControllerName()
            ]))->render();
        
            with (new FileGenerator( $path, $contents ) )->generate();
            
            $this->info( "Created : {$path}" );
        } 
        catch ( FileAlreadyExistException $e ) 
        {
            $this->error( "File : {$path} already exists." );
        }
    }
    
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['resource', InputArgument::REQUIRED, 'The name of the resource ( in singular ).'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }
    
    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain controller', null],
        ];
    }
    
    /**
     * @return string
     */
    protected function getControllerName()
    {
        return studly_case( $this->argument( 'resource' ) ) . 'Controller';
    }
    
    /**
     * Get controller path.
     *
     * @return string
     */
    protected function getControllerPath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());
        
        $controllerPath = GenerateConfigReader::read( 'controller' );
        
        return $path . $controllerPath->getPath() . '/' . $this->getControllerName() . '.php';
    }

}
