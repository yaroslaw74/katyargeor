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
use Symfony\Component\Filesystem\Filesystem;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): RedirectResponse
    {
        $filesystem = new Filesystem();
        if (!$filesystem->exists(KYG_PATH_CONFIG . 'env.yaml'))
            return $this->redirectToRoute('install_language');
        else
            return $this->redirectToRoute('app_home');
    }

    #[Route('/home', name: 'app_home')]
    public function home(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
