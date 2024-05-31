<?php

namespace App\Controller\Admin;

use App\Controller\HomeController;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
   // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());
        
        // return $this->render('admin/index.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }
     
    #[Route('/admin/home', name: 'admin_home')]
    public function home(): Response
    {
        // Appel au HomeController et récupération du contenu
        $homeResponse = $this->forward(HomeController::class . '::index');
        $homeContent = $homeResponse->getContent();

        return $this->render('Home/index.html.twig', [
            'homeContent' => $homeContent,
        ]);
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog Esprit Libre');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Home', 'fa fa-home','app_home');
        yield MenuItem::linkToCrud('Article', 'fas fa-list', Article::class);
        yield MenuItem::linkToRoute('Home', 'fa fa-home', 'admin_home');
    }
}
