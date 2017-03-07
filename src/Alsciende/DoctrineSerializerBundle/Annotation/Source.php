<?php

namespace Alsciende\DoctrineSerializerBundle\Annotation;

/**
 * @Source annotation 
 *
 * @Annotation
 * @Target("CLASS")
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class Source extends \Doctrine\Common\Annotations\Annotation
{
    
     /* @var string */
    public $break;

    /* @var string */
    public $group;

    /* @var string */
    public $path;

}
