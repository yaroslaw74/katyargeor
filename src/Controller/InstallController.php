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
use App\Modules\Administrations\Service\ArrayAccess;

class InstallController extends AbstractController
{
    private $Interface = [
        "Dir" => "ltr",
        "Theme" => "base",
        "Effect" => "blind",
        "Datepicker" => "ru",
        "Databstheme" => "auto"
    ];
    public function __construct(private ArrayAccess $ArrayAccess)
    {
    }
    #[Route('/install/language', name: 'install_language')]
    public function languageInstall(): Response
    {
        $Languages = Yaml::parseFile($this->getParameter('app.modules_dir') . DIRECTORY_SEPARATOR . 'languages.yaml');
        return $this->render('install/language.html.twig', [
            'Languages' => $Languages,
            'Interface' => $this->Interface
        ]);
    }

    #[Route('/install/app', name: 'install_app')]
    public function appInstall(Request $request): Response
    {
        $File = $this->getParameter('app.config.packages_dir') . DIRECTORY_SEPARATOR . 'translation.yaml';
        $translation = Yaml::parseFile($File);
        $Language = $request->request->getString('_locale');
        $translation['framework']['default_locale'] = $Language;
        $yaml = Yaml::dump($translation, 10);
        file_put_contents($File, $yaml);
        return $this->render('install/app.html.twig', [
            'Interface' => $this->Interface,
            'TimeZone' => $this->ArrayAccess->TimeZone,
            'TimeZoneDefault' => date_default_timezone_get(),
            'DataFormat' => $this->ArrayAccess->DataFormat,
            'TimeFormat' => $this->ArrayAccess->TimeFormat
        ]);
    }
    #[Route('/install/login', name: 'install_login')]
    public function loginInstall(Request $request): RedirectResponse
    {
        return $this->redirectToRoute('home');
    }
}
