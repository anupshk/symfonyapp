<?php

namespace Braindigit\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Braindigit\CategoryBundle\Entity\Category;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /*$nepal = new Category();
        $nepal->setTitle('Nepal');
        $nepal->setOwnerId(1);
        $nepal->setBundle('page');
        $nepal->setStatus(1);
        $nepal->setCreatedOn(new \DateTime());

        $india = new Category();
        $india->setTitle('India');
        $india->setOwnerId(1);
        $india->setBundle('page');
        $india->setStatus(1);
        $india->setCreatedOn(new \DateTime());

        $usa = new Category();
        $usa->setTitle('USA');
        $usa->setOwnerId(1);
        $usa->setBundle('page');
        $usa->setStatus(1);
        $usa->setCreatedOn(new \DateTime());

        $bagmati = new Category();
        $bagmati->setOwnerId(1);
        $bagmati->setBundle('page');
        $bagmati->setStatus(1);
        $bagmati->setCreatedOn(new \DateTime());
        $bagmati->setTitle('Bagmati');
        $bagmati->setParent($nepal);

        $gandaki = new Category();
        $gandaki->setOwnerId(1);
        $gandaki->setBundle('page');
        $gandaki->setStatus(1);
        $gandaki->setCreatedOn(new \DateTime());
        $gandaki->setTitle('Gandaki');
        $gandaki->setParent($nepal);

        $kaski = new Category();
        $kaski->setOwnerId(1);
        $kaski->setBundle('page');
        $kaski->setStatus(1);
        $kaski->setCreatedOn(new \DateTime());
        $kaski->setTitle('Kaski');
        $kaski->setParent($gandaki);

        $pokhara = new Category();
        $pokhara->setOwnerId(1);
        $pokhara->setBundle('page');
        $pokhara->setStatus(1);
        $pokhara->setCreatedOn(new \DateTime());
        $pokhara->setTitle('Pokhara');
        $pokhara->setParent($kaski);

        $ktm = new Category();
        $ktm->setOwnerId(1);
        $ktm->setBundle('page');
        $ktm->setStatus(1);
        $ktm->setCreatedOn(new \DateTime());
        $ktm->setTitle('Kathmandu');
        $ktm->setParent($bagmati);

        $lalitpur = new Category();
        $lalitpur->setOwnerId(1);
        $lalitpur->setBundle('page');
        $lalitpur->setStatus(1);
        $lalitpur->setCreatedOn(new \DateTime());
        $lalitpur->setTitle('Lalitpur');
        $lalitpur->setParent($bagmati);

        $thamel = new Category();
        $thamel->setOwnerId(1);
        $thamel->setBundle('page');
        $thamel->setStatus(1);
        $thamel->setCreatedOn(new \DateTime());
        $thamel->setTitle('Thamel');
        $thamel->setParent($ktm);

        $pulchowk = new Category();
        $pulchowk->setOwnerId(1);
        $pulchowk->setBundle('page');
        $pulchowk->setStatus(1);
        $pulchowk->setCreatedOn(new \DateTime());
        $pulchowk->setTitle('Pulchowk');
        $pulchowk->setParent($lalitpur);

        $florida = new Category();
        $florida->setOwnerId(1);
        $florida->setBundle('page');
        $florida->setStatus(1);
        $florida->setCreatedOn(new \DateTime());
        $florida->setTitle('Florida');
        $florida->setParent($usa);

        $miami = new Category();
        $miami->setOwnerId(1);
        $miami->setBundle('page');
        $miami->setStatus(1);
        $miami->setCreatedOn(new \DateTime());
        $miami->setTitle('Miami');
        $miami->setParent($florida);

        $california = new Category();
        $california->setOwnerId(1);
        $california->setBundle('page');
        $california->setStatus(1);
        $california->setCreatedOn(new \DateTime());
        $california->setTitle('California');
        $california->setParent($usa);

        $losangeles = new Category();
        $losangeles->setOwnerId(1);
        $losangeles->setBundle('page');
        $losangeles->setStatus(1);
        $losangeles->setCreatedOn(new \DateTime());
        $losangeles->setTitle('Los Angeles');
        $losangeles->setParent($california);

        $sanfrancisco = new Category();
        $sanfrancisco->setOwnerId(1);
        $sanfrancisco->setBundle('page');
        $sanfrancisco->setStatus(1);
        $sanfrancisco->setCreatedOn(new \DateTime());
        $sanfrancisco->setTitle('San Francisco');
        $sanfrancisco->setParent($california);

        $sacremento = new Category();
        $sacremento->setOwnerId(1);
        $sacremento->setBundle('page');
        $sacremento->setStatus(1);
        $sacremento->setCreatedOn(new \DateTime());
        $sacremento->setTitle('Sacremento');
        $sacremento->setParent($california);

        $newyork = new Category();
        $newyork->setOwnerId(1);
        $newyork->setBundle('page');
        $newyork->setStatus(1);
        $newyork->setCreatedOn(new \DateTime());
        $newyork->setTitle('New York');
        $newyork->setParent($usa);

        $nyc = new Category();
        $nyc->setOwnerId(1);
        $nyc->setBundle('page');
        $nyc->setStatus(1);
        $nyc->setCreatedOn(new \DateTime());
        $nyc->setTitle('New York City');
        $nyc->setParent($newyork);

        $brooklyn = new Category();
        $brooklyn->setOwnerId(1);
        $brooklyn->setBundle('page');
        $brooklyn->setStatus(1);
        $brooklyn->setCreatedOn(new \DateTime());
        $brooklyn->setTitle('Brooklyn');
        $brooklyn->setParent($nyc);

        $manhattan = new Category();
        $manhattan->setOwnerId(1);
        $manhattan->setBundle('page');
        $manhattan->setStatus(1);
        $manhattan->setCreatedOn(new \DateTime());
        $manhattan->setTitle('Manhattan');
        $manhattan->setParent($nyc);

        $maharastra = new Category();
        $maharastra->setOwnerId(1);
        $maharastra->setBundle('page');
        $maharastra->setStatus(1);
        $maharastra->setCreatedOn(new \DateTime());
        $maharastra->setTitle('Maharastra');
        $maharastra->setParent($india);

        $karnataka = new Category();
        $karnataka->setOwnerId(1);
        $karnataka->setBundle('page');
        $karnataka->setStatus(1);
        $karnataka->setCreatedOn(new \DateTime());
        $karnataka->setTitle('Karnataka');
        $karnataka->setParent($india);

        $banglore = new Category();
        $banglore->setOwnerId(1);
        $banglore->setBundle('page');
        $banglore->setStatus(1);
        $banglore->setCreatedOn(new \DateTime());
        $banglore->setTitle('Banglore');
        $banglore->setParent($karnataka);

        $mumbai = new Category();
        $mumbai->setOwnerId(1);
        $mumbai->setBundle('page');
        $mumbai->setStatus(1);
        $mumbai->setCreatedOn(new \DateTime());
        $mumbai->setTitle('Mumbai');
        $mumbai->setParent($maharastra);

        $andheri = new Category();
        $andheri->setOwnerId(1);
        $andheri->setBundle('page');
        $andheri->setStatus(1);
        $andheri->setCreatedOn(new \DateTime());
        $andheri->setTitle('Andheri');
        $andheri->setParent($mumbai);*/

        $em = $this->getDoctrine()->getManager();

        /*$em->persist($nepal);
        $em->persist($india);
        $em->persist($usa);
        $em->persist($bagmati);
        $em->persist($gandaki);
        $em->persist($kaski);
        $em->persist($pokhara);
        $em->persist($ktm);
        $em->persist($lalitpur);
        $em->persist($thamel);
        $em->persist($pulchowk);
        $em->persist($florida);
        $em->persist($california);
        $em->persist($newyork);
        $em->persist($miami);
        $em->persist($nyc);
        $em->persist($losangeles);
        $em->persist($sacremento);
        $em->persist($sanfrancisco);
        $em->persist($manhattan);
        $em->persist($brooklyn);
        $em->persist($maharastra);
        $em->persist($karnataka);
        $em->persist($banglore);
        $em->persist($mumbai);
        $em->persist($andheri);
        $em->flush();*/
        
        $repo = $em->getRepository('Braindigit\CategoryBundle\Entity\Category');
        //$categories = $repo->childrenHierarchy();
        $categories = $repo->childrenHierarchy(
            null, /* starting from root nodes */
            false, /* true: load all children, false: only direct */
            array(
                'decorate' => true,
                'representationField' => 'slug',
                'html' => true
            )
        );
        
        return $this->render('BraindigitCategoryBundle:Default:index.html.twig', array('categories' => $categories));
    }
}
