<?php declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function indexAction()
    {
//        if ($this->container->getParameter('kernel.environment') !== 'dev') {
//            throw $this->createAccessDeniedException('You don\'t have access to this page!');
//        }

        return new Response('Property Window Engine');
    }

    /**
     * @Route("/wget/{propertyId}")
     *
     * @param int $propertyId
     */
    public function wgetAction(int $propertyId)
    {
        $dir   = "./../wget_images/";
        $files = glob($dir.'*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $json      = file_get_contents(
            'http://propertywindow.com/login2/ajax/properties_sale/view_property.php?ID='.$propertyId
        );
        $array     = json_decode($json, true);
        $ImagePath = str_replace("../../", "http://propertywindow.com/", $array['ImagePath']);
        $ImagePath = preg_replace("/ /", "%20", $ImagePath);

        copy($ImagePath, $dir.'1.jpg');

        $json  = file_get_contents(
            'http://propertywindow.com/login2/ajax/properties_sale/images.php?ID='.$propertyId
        );
        $array = json_decode($json, true);
        $i     = 2;

        foreach ($array as $item) {
            $ImagePath = preg_replace("/ /", "%20", $item['ImagePath']);
            copy($ImagePath, $dir.$i.'.jpg');
            $i++;
        }

        for ($a = $i; $a < 21; $a++) {
            $rand      = array_rand($array, 1);
            $ImagePath = preg_replace("/ /", "%20", $array[$rand]['ImagePath']);
            copy($ImagePath, $dir.$a.'.jpg');
        }

        if (is_dir($dir)) {
            $dh = opendir($dir);
            if ($dh) {
                while (($file = readdir($dh)) !== false) {
                    dump($file);
                }
                closedir($dh);
            }
        }

        exit;
    }
}
