<?php
namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UploadLicenceDocArticle implements EventSubscriberInterface {

    /** @var EntityManager */
    public $em;
    public $params;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $params)
    {
        $this->em = $em;
        $this->params = $params;
    }

    public static function getSubscribedEvents(){
        return [
            KernelEvents::VIEW =>['convertImage', EventPriorities::PRE_WRITE]
        ];
    }
    public function convertImage(ViewEvent $event){
        $article = $event->getControllerResult();
        $methods = $event->getRequest()->getMethod();
        if ($article instanceof Article && $methods == 'POST'){
            $imageBase64 = $article->getImage();
            if ($imageBase64 != null) {
                $path = $this->base64ToImage($imageBase64,$article);
                if ($path != 'ErrorFormat'){
                    $article->setImage($path);
                    $this->em->persist($article);
                    $this->em->flush();
                }else{
                    throw new \Exception("Format incorrect, veuillez inserez une image au format 'jpg', 'jpeg', 'pdf' ou 'png'");
                }
            }
        }
    }

    //TODO D'ONT WORK WITH PDF
    public function base64ToImage($base64,$article){
        $formatAuthorized = [
            'jpg',
            'jpeg',
            "png",
            "pdf"
        ];
        // $idArticle = $article->getId();
        $webPath = $this->getApplicationRootDir() . '/public/images/articles/';
        // $webPath = $webPath . $idArticle . "/" ;
        // var_dump($pathFolder);
        // die("mmm");
        if (!file_exists($webPath)) {
            mkdir($webPath, 0777, true);
        }
        $image_parts = explode(";base64,", $base64);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        if(in_array($image_type,$formatAuthorized) ){
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid().'.'.$image_type;
            $file = $webPath . $imageName;
            file_put_contents($file, $image_base64);
            $path = "/images/articles/" .$imageName;
            return $path;
        }
        return "ErrorFormat";
    }

    public function getApplicationRootDir(){
        return $this->params->get('kernel.project_dir');
    }

}