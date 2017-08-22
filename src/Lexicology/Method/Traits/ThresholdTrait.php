<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method\Traits;


trait ThresholdTrait
{
    protected $threshold;

    /**
     * @return float
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @param float $threshold
     * @return $this
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;
        return $this;
    }
}