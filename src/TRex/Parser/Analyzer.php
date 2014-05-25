<?php
namespace TRex\Parser;

use TRex\Reflection\ClassReflection;

/**
 * Class Analyzer
 * @package TRex\Parser
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Analyzer
{
    /**
     * @param string $filePath
     * @return ClassReflection[]
     */
    public function getClassReflections($filePath)
    {
        $this->includeMockFile($filePath);
        $result = array();
        foreach ($this->getClassNames($filePath) as $className) {
            $result[$className] = new ClassReflection($className);
        }
        return $result;
    }

    /**
     * @param string $filePath
     * @return string[]
     */
    private function getClassNames($filePath)
    {
        $tokenizer = new Tokenizer(file_get_contents($filePath));
        return $tokenizer->getInstantiableClassNames();
    }

    /**
     * @param string $filePath
     * @return mixed
     */
    private function includeMockFile($filePath)
    {
        return require_once $filePath;
    }
}
