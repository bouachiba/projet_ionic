<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagsDataTransformer implements DataTransformerInterface
{

    private static $tagDelimiter = ',';

    private $entityManager;

    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
        $this->repository = $em->getRepository('AppBundle:Tag');
    }

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * This method is called on two occasions inside a form field:
     *
     * 1. When the form field is initialized with the data attached from the datasource (object or array).
     * 2. When data from a request is submitted using {@link Form::submit()} to transform the new input data
     *    back into the renderable format. For example if you have a date field and submit '2009-10-10'
     *    you might accept this value because its easily parsed, but the transformer still writes back
     *    "2009/10/10" onto the form field (for further displaying or other purposes).
     *
     * This method must be able to deal with empty values. Usually this will
     * be NULL, but depending on your implementation other empty values are
     * possible as well (such as empty strings). The reasoning behind this is
     * that value transformers must be chainable. If the transform() method
     * of the first value transformer outputs NULL, the second value transformer
     * must be able to process that value.
     *
     * By convention, transform() should return an empty string if NULL is
     * passed.
     *
     * @param mixed $tagCollection The value in the original representation
     *
     * @return mixed The value in the transformed representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function transform($tagCollection)
    {
        $tagsArray = array_map(function($tagEntity){
            return $tagEntity->getTagName();
        },
            $tagCollection->toArray()
        );

        return implode(static::$tagDelimiter.' ', $tagsArray);
    }

    /**
     * Transforms a value from the transformed representation to its original
     * representation.
     *
     * This method is called when {@link Form::submit()} is called to transform the requests tainted data
     * into an acceptable format for your data processing/model layer.
     *
     * This method must be able to deal with empty values. Usually this will
     * be an empty string, but depending on your implementation other empty
     * values are possible as well (such as empty strings). The reasoning behind
     * this is that value transformers must be chainable. If the
     * reverseTransform() method of the first value transformer outputs an
     * empty string, the second value transformer must be able to process that
     * value.
     *
     * By convention, reverseTransform() should return NULL if an empty string
     * is passed.
     *
     * @param mixed $value The value in the transformed representation
     *
     * @return mixed The value in the original representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function reverseTransform($value)
    {
        $tagsCollection = new ArrayCollection();

        // Transformation de la liste des tags en tableau
        $tagsArray = explode(static::$tagDelimiter, $value);
        // Nettoyage des tags
        $tagsArray = array_map(function($tag){
            return trim($tag);
        }, $tagsArray);
        // unicité des tags
        $tagsArray = array_unique($tagsArray);

        foreach($tagsArray as $tagName){
            if(! empty($tagName)){
                // Recherche d'un tag existant
                $tagEntity = $this->repository->findOneByTagName($tagName);

                // Si non trouvé, instanciation d'un nouveau tag
                if(! $tagEntity){
                    $tagEntity = new Tag();
                    $tagEntity->setTagName($tagName);
                }

                // Ajout du tag à la collection
                $tagsCollection->add($tagEntity);
            }
        }

        return $tagsCollection;
    }
}