<?php

namespace Bookshop;

/**
 * PagingResult
 *
 *
 * @package
 * @subpackage
 * @author     John Doe <jd@fbi.gov>
 */
class PagingResult extends BaseObject {

    private $result;
    private $offset;
    private $totalCount;

    public function __construct($result, $offset, $totalCount) {
        $this->result = $result;
        $this->offset = $offset;
        $this->totalCount = $totalCount;
    }

    /**
     * getter for result
     *
     * @return string
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * getter for offset
     *
     * @return string
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * getter for total count
     *
     * @return string
     */
    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * getter for first page position
     *
     * @return string
     */
    public function getPositionOfFirst() {
        return $this->getOffset() + 1;
    }

    /**
     * getter for last page position
     *
     * @return string
     */
    public function getPositionOfLast() {
        return $this->getOffset() + sizeof($this->result);
    }

}