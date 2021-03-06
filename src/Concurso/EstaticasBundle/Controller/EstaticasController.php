<?php

namespace Concurso\EstaticasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EstaticasController extends Controller
{
    public function indexAction()
    {
        return $this->render('ConcursoEstaticasBundle:Default:index.html.twig', array());
    }
    public function convocatoriaAction()
    {
        return $this->render('ConcursoEstaticasBundle:Default:convocatoria.html.twig', array());
    }
    public function programaAction()
    {
        return $this->render('ConcursoEstaticasBundle:Default:programa.html.twig', array());
    }
    public function ejemplosAction()
    {
        return $this->render('ConcursoEstaticasBundle:Default:ejemplos.html.twig', array());
    }
    public function registroAction(Request $peticion)
    {
        
            $usuario = $this->get('security.context')->getToken()->getUser();
            $idUsuario=$usuario->getId();
            
            $em = $this->getDoctrine()->getManager();
            
            $dql = $em->createQueryBuilder();
 
            $dql->select('Equipo.nombre','Equipo.id','Equipo.preparatoria')
                ->from('RegistroBundle:Equipo', 'Equipo')
                ->where('Equipo.idUsuario = :id_Usuario' );
            $dql->setParameter('id_Usuario', $idUsuario);

            $equipo=$dql->getQuery()->getResult();

            
            
            $query = $em->createQuery(
                'SELECT p
                FROM RegistroBundle:Alumno p
                WHERE p.idEquipo = (SELECT e.id FROM RegistroBundle:Equipo e WHERE e.idUsuario= :id_Usuario )'
            )->setParameter('id_Usuario', $idUsuario);

            $alumnos = $query->getResult();

            
            
            return $this->render('ConcursoEstaticasBundle:Default:registro.html.twig', array(
                    'usuario' => $usuario,
                    'equipos' => $equipo,
                    'alumnos' => $alumnos
                ));
        
    }
    public function contactosAction()
    {
        return $this->render('ConcursoEstaticasBundle:Default:contactos.html.twig', array());
    }
    
}