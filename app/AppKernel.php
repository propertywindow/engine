<?php
declare(strict_types = 1);

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new AgentBundle\AgentBundle(),
            new AppBundle\AppBundle(),
            new AppointmentBundle\AppointmentBundle(),
            new AlertBundle\AlertBundle(),
            new AuthenticationBundle\AuthenticationBundle(),
            new PropertyBundle\PropertyBundle(),
            new InvoiceBundle\InvoiceBundle(),
            new LogBundle\LogBundle(),
            new ConversationBundle\ConversationBundle(),
            new ClientBundle\ClientBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }

    /**
     * @param LoaderInterface $loader
     *
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
