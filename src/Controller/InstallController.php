<?php
/**********************************************************************************
 * @Project    KYG Framework for business
 * @Version    1.0,0
 *
 * @Copyright  (C) 2025 Kataev Yaroslav Georgievich 
 * @E-mail     yaroslaw74@gmail.com
 * @License    GNU General Public License version 3 or later; see LICENSE.md
 *********************************************************************************/
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use App\Modules\Administrations\Resource\ArrayAccess;

class InstallController extends AbstractController
{
    private ArrayAccess $ArrayAccess;
    public function __construct()
    {
        $this->ArrayAccess = new ArrayAccess;
    }
    #[Route('/install/language', name: 'install_language')]
    public function languageInstall(): Response
    {
        $Languages = Yaml::parseFile($this->getParameter('app.extensions_dir') . DIRECTORY_SEPARATOR . 'languages.yaml');
        return $this->render('install/language.html.twig', [
            'Languages' => $Languages,
        ]);
    }

    #[Route('/install/app', name: 'install_app')]
    public function appInstall(Request $request): Response
    {
        $File = $this->getParameter('app.config.packages_dir') . DIRECTORY_SEPARATOR . 'translation.yaml';
        $translation = Yaml::parseFile($File);
        $translation['framework']['default_locale'] = $request->request->getString('_locale');
        $yanl = Yaml::dump($translation, 10);
        chmod($File, 0777);
        file_put_contents($File, $yanl);
        chmod($File, 0755);
        return $this->render('install/app.html.twig', [

        ]);
    }
}
