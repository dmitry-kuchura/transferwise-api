<?php
declare(strict_types=1);

namespace TWAPI;

use TWAPI\Transport\Transport;

/**
 * Class TWProfiles
 * @package API\Profiles
 */
class ProfilesAPI
{
    /**
     * @var Transport
     */
    protected $transport;

    protected const URL_TEMPLATE_LIST
        = '/transfers/{?offset,limit,profile,status,createdDateStart,createdDateEnd}';

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    public function list($filters = [])
    {
        return $this->transport->get(
            self::URL_TEMPLATE_LIST,
            $filters
        );
    }

    public function create($profile)
    {
        throw new \Exception('Not Yet Implemented');
    }

    public function update($profile)
    {
        throw new \Exception('Not Yet Implemented');
    }

    public function getById($profileId)
    {
        throw new \Exception('Not Yet Implemented');
    }


}