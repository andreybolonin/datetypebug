<?php

namespace App\Controller;


use App\Entity\StatisticApp;
use App\Form\StatisticAppType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: ['admin' => '/admin/statistic_app', 'player' => '/player/statistic_app'])]
//#[IsGranted(new Expression("is_granted('ROLE_ADMIN') or is_granted('ROLE_TOP') or is_granted('ROLE_FIN') or is_granted('ROLE_CN') or is_granted('ROLE_PLAYER') or is_granted('ROLE_SUBAFF') or is_granted('ROLE_OP') or is_granted('ROLE_SPT_CN') or is_granted('ROLE_SPT_CN_PRO')"))]
class StatisticAppController extends AbstractController
{
    #[Route(path: '/new', name: 'statistic_app_new', methods: ['GET', 'POST'])]
//    #[IsGranted(new Expression("is_granted('ROLE_ADMIN') or is_granted('ROLE_CN') or is_granted('ROLE_SPT_CN_PRO') or is_granted('ROLE_FIN')"))]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
//        $this->denyAccessUnlessGranted(PermissionEnum::PERMISSION_FULL->name, SectionEnum::SECTION_STATISTIC_APP->name);

        $StatisticApp = new StatisticApp();
        $form = $this->createForm(StatisticAppType::class, $StatisticApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($StatisticApp);
            $em->flush();

            // ищем связь со сделкой, если нашли то проставляем в статистику
            $deals = $em->getRepository(Deal::class)
                ->createQueryBuilder('c')
                ->leftJoin('c.room', 'room')
                ->leftJoin('c.roomAccountNicknames', 'rans')
                ->andWhere('LOWER(room.name) = LOWER(:room)')
                ->andWhere('LOWER(rans.roomAccount) = LOWER(:roomAccount)')
                ->setParameter('room', $StatisticApp->getRoom()->getName())
                ->setParameter('roomAccount', $StatisticApp->getAccount())
                ->getQuery()
                ->getResult();

            if (count($deals) > 0) {
                $StatisticApp->setDeal($deals[0]);
                $em->persist($StatisticApp);
                $em->flush();
            }

            return $this->redirectToRoute('statistic_app_index');
        }

        return $this->render('statistic_app/new.html.twig', [
            'statistic_cn' => $StatisticApp,
            'form' => $form,
        ]);
    }
}
