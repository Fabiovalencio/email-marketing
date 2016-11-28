<?php

namespace CodeEmailMKT\Domain\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use Psr\Http\Message\ResponseInterface;

interface CampaignDeleteInterface
{
    public function setCampaign(Campaign $campaign);
    public function deleteCampaign();
}