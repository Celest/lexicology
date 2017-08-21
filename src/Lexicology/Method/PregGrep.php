<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method;


class PregGrep extends AbstractMethod implements MethodInterface
{
    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function rate(string $a, string $b):? int
    {
        $quotedField = preg_replace('/[\s\_]/', '.*', '~' . preg_quote($this->getField(), '~') . '~i');

        $pregMatchA = preg_match($quotedField, $a) === 1;
        $pregMatchB = preg_match($quotedField, $b) === 1;

        if ($pregMatchA === $pregMatchB) {
            return 0;
        } else {
            if ($pregMatchA) {
                return 1;
            } elseif ($pregMatchB) {
                return -1;
            }
        }
        return null;
    }

    /**
     * @param array $possibleValues
     * @return array
     */
    public function filter(array $possibleValues): array
    {
        $quotedValue = preg_replace('/[\s\_]/', '.*', '~' . preg_quote($this->getField(), '~') . '~i');
        return array_values(preg_grep($quotedValue, $possibleValues));
    }
}