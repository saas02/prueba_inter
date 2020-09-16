<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
//services
use App\Service\InterGeneralService;
//entities
use App\Entity\Estudiantes;
use App\Entity\Profesores;
use App\Entity\Materias;
use App\Entity\EstudiantesMateriasProfesores;

class ServicesController extends AbstractController {

    public function __construct(InterGeneralService $InterGeneralService, SerializerInterface $serializer) {
        $this->InterGeneralService = $InterGeneralService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/v1/inter/consultas/materias", name="consulta_materias", methods={"GET", "POST"} )
     */
    public function materias() {
        try {
            $em = $this->getDoctrine()->getManager();
            $request = Request::createFromGlobals();
            $validateMethod = $this->InterGeneralService->validateMethod($request, "POST");

            if ($validateMethod['message'] == 'error') {
                $response = $this->InterGeneralService->generateResponse($validateMethod['code'], $validateMethod['message'], $validateMethod['result']);
                return new Response($response);
            }
            $parametersRequest = json_decode($request->getContent(), true);
            if (empty($parametersRequest)) {
                $message = "error";
                $code = Response::HTTP_BAD_REQUEST; //400
                $result = "1. Error con los parametros de entrada.";
                $response = $this->InterGeneralService->generateResponse($code, $message, $result);
                return new Response($response);
            } else {
                $parametersMandatory = ["info", "data"];
                $validateInfo = $this->InterGeneralService->validateRequest($parametersRequest, $parametersMandatory);
                if (isset($validateInfo['error'])) {
                    $message = "error";
                    $code = Response::HTTP_BAD_REQUEST; //400
                    $response = "2. Error con los parametros de entrada." . $validateInfo['error'];
                    $response = $this->InterGeneralService->generateResponse($code, $message, $response);
                } else {                    
                    $info = json_decode(base64_decode($parametersRequest['info']), true);
                    $data = $parametersRequest['data'];
                    $result['info'] = $parametersRequest['info']; 
                    switch ($data){
                        case 'registrar_materias':                            
                            $result['materias'] = $this->getDoctrine()->getRepository(Estudiantes::class)->findAllRegisterMaterias($info);                            
                            $result['profesores'] = $this->getDoctrine()->getRepository(Estudiantes::class)->findAllRegisterProfesores($info);                            
                            if(isset($result['materias']['error'])){
                                $result = $result['materias'];
                            }
                            break;
                        case 'cancelar_materias':
                            
                            break;
                        case 'ver_materias':
                            switch ($info['type']){
                                case 'estudiante':
                                    $result['estudiante'] = $this->getDoctrine()->getRepository(Estudiantes::class)->findAllInfoMaterias($info);
                                    if(!empty($result)){
                                        $result['companeros'] = $this->getDoctrine()->getRepository(Estudiantes::class)->findAllStudentsMaterias($info);
                                    }
                                    break;
                                case 'profesor':
                                    $result = $this->getDoctrine()->getRepository(Profesores::class)->findAllInfoMaterias($info);
                                    break;
                            }
                            break;
                    }                                                            
                    $response = $this->InterGeneralService->generateResponse(Response::HTTP_OK, "success", $result);
                }
            }
        } catch (DBALException $e) {            
            $result = $e->getMessage();
            $response = $this->InterGeneralService->generateResponse(Response::HTTP_OK, "success", $result);
        } catch (\Exception $e) {
            $result = $e->getMessage();
            $response = $this->InterGeneralService->generateResponse(Response::HTTP_OK, "success", $result);            
        }
        
        return new Response($response);
    }
    
    
    /**
     * @Route("/v1/inter/registrar/materias", name="registrar_materias", methods={"GET", "POST"} )
     */
    public function registar_materias() {
        try {
            $em = $this->getDoctrine()->getManager();
            $request = Request::createFromGlobals();
            $validateMethod = $this->InterGeneralService->validateMethod($request, "POST");

            if ($validateMethod['message'] == 'error') {
                $response = $this->InterGeneralService->generateResponse($validateMethod['code'], $validateMethod['message'], $validateMethod['result']);
                return new Response($response);
            }
            $parametersRequest = json_decode($request->getContent(), true);
            if (empty($parametersRequest)) {
                $message = "error";
                $code = Response::HTTP_BAD_REQUEST; //400
                $result = "1. Error con los parametros de entrada.";
                $response = $this->InterGeneralService->generateResponse($code, $message, $result);
                return new Response($response);
            } else {
                $parametersMandatory = ["info", "materias", "profesores"];
                $validateInfo = $this->InterGeneralService->validateRequest($parametersRequest, $parametersMandatory);
                if (isset($validateInfo['error'])) {
                    $message = "error";
                    $code = Response::HTTP_BAD_REQUEST; //400
                    $response = "2. Error con los parametros de entrada." . $validateInfo['error'];
                    $response = $this->InterGeneralService->generateResponse($code, $message, $response);
                } else {                     
                    $info = json_decode(base64_decode($parametersRequest['info']), true);                    
                    $id_profesor = $parametersRequest['profesores'];
                    $id_materia = $parametersRequest['materias'];
                    $result['info'] = $parametersRequest['info'];
                    $EstudiantesMateriasProfesores = new EstudiantesMateriasProfesores();
                    $EstudiantesMateriasProfesores->setIdEstudiante($info['id']);
                    $EstudiantesMateriasProfesores->setIdProfesor($id_profesor);
                    $EstudiantesMateriasProfesores->setIdMateria($id_materia);
                    $EstudiantesMateriasProfesores->setIsActive(1);
                    $EstudiantesMateriasProfesores->setCreatedAt(new \DateTime());
                    $EstudiantesMateriasProfesores->setUpdatedAt(new \DateTime());
                    $em->persist($EstudiantesMateriasProfesores);                
                    $em->flush();
                    $response = $this->InterGeneralService->generateResponse(Response::HTTP_OK, "success", $result);
                }
            }
        } catch (DBALException $e) {            
            $result = $e->getMessage();
            $response = $this->InterGeneralService->generateResponse(Response::HTTP_OK, "success", $result);
        } catch (\Exception $e) {
            $result = $e->getMessage();
            $response = $this->InterGeneralService->generateResponse(Response::HTTP_OK, "success", $result);            
        }
        
        return new Response($response);
    }

}
