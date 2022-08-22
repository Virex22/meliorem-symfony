<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @codeCoverageIgnore
 */
class MakeEntityServiceCommand extends Command
{
    protected static $defaultName = 'make:entityService';
    protected static $defaultDescription = 'make a EntityService (instance of AbstractEntityService)';

    protected function configure(): void
    {
        $this
            ->addArgument('entityName', InputArgument::REQUIRED, 'the name of your entity')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('entityName');

        $io->info('Creating service...');

        $entityName = $arg1;
        $entityClass = 'src\\Entity\\' . $entityName;
        if (!file_exists($entityClass . '.php')) {
            $io->error(sprintf('Entity %s not found', $entityClass));
            return Command::FAILURE;
        }

        if (!file_exists('src/Service/' . $arg1 . 'Service.php')) {
            file_put_contents(
                'src/Service/' . $arg1 . 'Service.php',
                $this->getService($arg1)
            );
        }
        else {
            $io->error(sprintf('Service %s already exists', $arg1 . 'Service'));
            return Command::FAILURE;
        }

        file_put_contents(
            'src/Service/' . $arg1 . 'Service.php',
            $this->getService($arg1)
        );

        $io->success('Success!');

        return Command::SUCCESS;
    }

    protected function getService($name) : string
    {
        $serviceName = $name . 'Service';
        $camelCaseName = lcfirst($name);
        $pascalCaseName = ucfirst($name);

        return <<<EOF
<?php
namespace App\Service;

use App\Entity\\$pascalCaseName;

class $serviceName extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return $pascalCaseName::class;
    }

    public function create(Array \$data) : $pascalCaseName
    {
        throw new \Exception('TODO : implement create on $serviceName');

        //\$this->validateRequiredData(\$data, 'attribute', 'attribute','attribute');
        //$$camelCaseName = \$this->createEntity(\$data, 'attribute', 'attribute','attribute');
        
        //return $$camelCaseName;
    }


    public function edit(object $$camelCaseName ,Array \$data) : $pascalCaseName
    {
        throw new \Exception('TODO : implement edit on $serviceName');

        //\$this->editEntity($$camelCaseName, \$data, 'attribute', 'attribute','attribute');
        
        return $$camelCaseName;
    }
}
EOF;
    }  
}
