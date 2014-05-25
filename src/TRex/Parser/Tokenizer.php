<?php
namespace TRex\Parser;

/**
 * Class Tokenizer
 * @package TRex\Parser
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Tokenizer
{
    /**
     * @var array
     */
    private $tokens;

    /**
     * @param $content
     */
    public function __construct($content)
    {
        $this->setTokens(token_get_all($content));
    }

    /**
     * @return array
     */
    public function getInstantiableClassNames()
    {
        $result = array();
        $currentTokenType = 0;
        foreach ($this->getTokens() as $token) {
            if ($token[0] === T_ABSTRACT || $token[0] === T_CLASS) {
                $currentTokenType += $token[0];
            } elseif ($currentTokenType && $token[0] === T_STRING) {
                if ($currentTokenType === T_CLASS) {
                    $result[] = $token[1];
                }
                $currentTokenType = 0;
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    private function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Setter of $tokens
     *
     * @param array $tokens
     */
    private function setTokens(array $tokens)
    {
        $this->tokens = $tokens;
    }
}
