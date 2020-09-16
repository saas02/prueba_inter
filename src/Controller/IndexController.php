<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Estudiantes;
use App\Entity\Profesores;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    
    /**
     * @Route("/Login", name="login")
     */
    public function login(Request $request)
    {        
        try{
            
            if($request->request->has('identificacion')){
                $session = $request->getSession();
                $identificacion = $request->request->get('identificacion');
                $password = $request->request->get('password');
                
                if($identificacion == 'admin' && $password == 'admin'){                    
                    $session->set('admin', true);                        
                    return $this->redirectToRoute('index');
                }

                $validaEstudiantes = $this->getDoctrine()
                         ->getRepository(Estudiantes::class)
                         ->findOneBy([
                             'identificacion' => $identificacion, 
                             'contrasena' => $password,
                             'is_active' => 1
                         ]);
                 if(empty($validaEstudiantes)){
                     $validaProfesores = $this->getDoctrine()
                         ->getRepository(Profesores::class)
                        ->findOneBy([
                             'identificacion' => $identificacion, 
                             'contrasena' => $password,
                            'is_active' => 1
                         ]);                     
                     if(empty($validaProfesores)){
                         return $this->render('login/login.html.twig', [
                             'error' => 'Usuario No encontrado',
                         ]);                    
                     }else{                        
                        $data_session = [
                            "id" => $validaProfesores->getId(),
                            "nombre" => $validaProfesores->getNombres(),
                            "apellidos" => $validaProfesores->getApellidos(),
                            "identicacion" => $validaProfesores->getIdentificacion(),
                            "type" => 'profesor'
                        ];                        
                        
                        $session->set('data_session', base64_encode(json_encode($data_session)));
                        $session->set('profesor_session', true);
                        $session->set('nombre', $validaProfesores->getNombres().' '.$validaProfesores->getApellidos());
                        return $this->redirectToRoute('index');
                     }
                 }else{                     
                    $data_session = [
                        "id" => $validaEstudiantes->getId(),
                        "nombre" => $validaEstudiantes->getNombres(),
                        "apellidos" => $validaEstudiantes->getApellidos(),
                        "identicacion" => $validaEstudiantes->getIdentificacion(),
                        "type" => 'estudiante'
                    ];
                    $session->set('data_session', base64_encode(json_encode($data_session)));
                    $session->set('estudiante_session', true); 
                    $session->set('nombre', $validaEstudiantes->getNombres().' '.$validaEstudiantes->getApellidos());
                    return $this->redirectToRoute('index');
                 }                
             }else{
                 return $this->render('login/login.html.twig', [
                     'controller_name' => 'IndexController',
                 ]);
             }            
        }  catch(DBALException $e){
            $errorMessage = $e->getMessage();
            return $this->render('login/login.html.twig', [
                'error' => $errorMessage,
            ]);
        }    
        catch(\Exception $e){
            $errorMessage = $e->getMessage();
            return $this->render('login/login.html.twig', [
                'error' => $errorMessage,
            ]);
        }
    }
    
    /**
     * @Route("/cerrar_sesion", name="cerrar_sesion")
     */
    public function close_session(Request $request)
    {        
        try{
            $session = $request->getSession();
            
            if($session->has('estudiante_session')){
                $session->remove('estudiante_session');
            }elseif($session->has('profesor_session')){
                $session->remove('profesor_session');
            }elseif($session->has('admin')){
                $session->remove('admin');
            }
            $session->remove('nombre');
            return $this->redirectToRoute('index');
        }  catch(DBALException $e){
            $errorMessage = $e->getMessage();
            return $this->render('login/login.html.twig', [
                'error' => $errorMessage,
            ]);
        }    
        catch(\Exception $e){
            $errorMessage = $e->getMessage();
            return $this->render('login/login.html.twig', [
                'error' => $errorMessage,
            ]);
        }
    }
}
