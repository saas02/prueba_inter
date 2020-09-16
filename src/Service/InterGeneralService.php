<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class InterGeneralService {

    public function __construct(EntityManagerInterface $entityManager) {                
        $this->entityManager = $entityManager;      
    }
       
    public function validateMethod($request, $method){
        $code = Response::HTTP_OK;
        $message = 'success';
        $result = 'Metodo correcto';

        if (!$request->isMethod($method)) {
            $code = Response::HTTP_METHOD_NOT_ALLOWED;//405
            $message = 'error';
            $result = 'Metodo no soportado.';
        }

        $result = [
            "message" => $message,
            "code" => $code,
            "result" => $result
        ];

        return $result;
    }

    public function generateResponse($code, $message, $result){
        return json_encode([
            "message" => $message,
            "code" => $code,            
            "result" => $result
        ]);
    }

    public function validateRequest($parameters, $parametersMandatory){
        $result = [];             
        foreach($parametersMandatory as $parameter){           
            if(!array_key_exists($parameter, $parameters)){                
                $result['error'] = 'Error en el campo '.$parameter;
            }
        }
        
        return $result;

    }        
    
}