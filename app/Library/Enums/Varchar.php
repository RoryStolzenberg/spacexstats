<?php
namespace SpaceXStats\Library\Enums;

abstract class Varchar extends Enum {

    /**
     * Varchar constant for data types requiring tiny values (maximum length of 50)
     *
     * @var int
     */
    const tiny = 50;

    /**
     * Varchar constant for data types requiring small values (maximum length of 100)
     *
     * @var int
     */
    const small = 100;

    /**
     * Varchar constant for data types requiring compact values (maximum length of 500)
     *
     * @var int
     */
    const compact = 500;

    /**
     * Varchar constant for data types requiring medium values (maximum length of 1000)
     *
     * @var int
     */
    const medium = 1000;

    /**
     * Varchar constant for data types requiring large values (maximum length of 5000)
     *
     * @var int
     */
    const large = 5000;

    /**
     * Varchar constant for data types requiring extra large values (maximum length of 10000)
     *
     * @var int
     */
    const xlarge = 10000;

    /**
     * Varchar constant for data types requiring extra extra large values (maximum length of 50000)
     *
     * @var int
     */
    const xxlarge = 50000;
}