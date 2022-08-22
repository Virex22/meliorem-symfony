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
class MakeCrudControllerCommand extends Command
{
    protected static $defaultName = 'make:crudController';
    protected static $defaultDescription = 'make a CRUD controller (instance of AbstractCRUDController)';

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

        $io->info('Creating CRUD controller...');

        $entityName = $arg1;
        $entityClass = 'src\\Entity\\' . $entityName;
        if (!file_exists($entityClass . '.php')) {
            $io->error(sprintf('Entity %s not found', $entityClass));
            return Command::FAILURE;
        }

        if (!file_exists('src/Controller/' . $arg1 . 'Controller.php')) {
            file_put_contents(
                'src/Controller/' . $arg1 . 'Controller.php',
                $this->getController($arg1)
            );
        }
        else {
            $io->error(sprintf('Controller %s already exists', $arg1 . 'Controller'));
            return Command::FAILURE;
        }

        $io->success('Success!');

        return Command::SUCCESS;
    }

    private function convertKebabCase(string $string)
    {
        // Replace repeated spaces to underscore
        $string = preg_replace('/[\s.]+/', '_', $string);
        // Replace un-willing chars to hyphen.
        $string = preg_replace('/[^0-9a-zA-Z_\-]/', '-', $string);
        // Skewer the capital letters
        $string = strtolower(preg_replace('/[A-Z]+/', '-\0', $string));
        $string = trim($string, '-_');
    
        return preg_replace('/[_\-][_\-]+/', '-', $string);
    }

    protected function getController($name) : string
    {
        $controllerName = $name . 'Controller';
        $camelCaseName = lcfirst($name);
        $pascalCaseName = ucfirst($name);
        $kebabCaseName = $this->convertKebabCase($name);

        return <<<EOF
<?php

namespace App\Controller;

use App\Entity\\$pascalCaseName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/{$kebabCaseName}")
 **/
class $controllerName extends AbstractCRUDController
{
    protected function getEntityClass(): string
    {
        return $pascalCaseName::class;
    }
    /**
     * @Route("/", name="$camelCaseName index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return \$this->getAll();
    }
    /**
     * @Route("/{id}", name="$camelCaseName show", methods={"GET"})
     */
    public function show(int \$id): JsonResponse
    {
        return \$this->getById(\$id);
    }
    /**
     * @Route("/{id}", name="$camelCaseName remove", methods={"DELETE"})
     */
    public function remove(int \$id): JsonResponse
    {
        return \$this->delete(\$id);
    }
    /**
     * @Route("/", name="$camelCaseName new", methods={"POST"})
     */
    public function new(Request \$request): JsonResponse
    {
        return \$this->create(\$request);
    }
    /**
     * @Route("/{id}", name="$camelCaseName edit", methods={"PATCH"})
     */
    public function edit(int \$id, Request \$request): JsonResponse
    {
        return \$this->update(\$id, \$request);
    }
}
EOF;
    }  
}
