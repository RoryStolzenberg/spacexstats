<?php
namespace SpaceXStats\Enums;

abstract class Varchar {

    /**
     * Varchar constant for data types requiring small values (maximum length of 50)
     *
     * @var int
     */
    const small = 50;

    /**
     * Varchar constant for data types requiring compact values (maximum length of 100)
     *
     * @var int
     */
    const compact = 100;

    /**
     * Varchar constant for data types requiring medium values (maximum length of 500)
     *
     * @var int
     */
    const medium = 500;

    /**
     * Varchar constant for data types requiring large values (maximum length of 1000)
     *
     * @var int
     */
    const large = 1000;

    /**
     * Varchar constant for data types requiring extra large values (maximum length of 5000)
     *
     * @var int
     */
    const xlarge = 5000;
}