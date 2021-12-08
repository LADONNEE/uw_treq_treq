<?php

namespace App\WebServices\UwGroups;

use GuzzleHttp\Client as GuzzleClient;

class UwGroupsService
{
    private $uriBase;
    private $certFile;

    public function __construct()
    {
        $this->uriBase = 'https://groups.uw.edu/group_sws/v3/group/';
        $this->certFile = base_path('/ssl/groups-client.educ.uw.edu/public.pem');
    }

    public function lookup($groupId)
    {
        return $this->get($groupId);
    }

    public function members($groupId)
    {
        return $this->get($groupId . '/member');
    }

    public function create($groupId, $data)
    {
        $body = new \stdClass();
        $body->data = $data;

        return $this->put($groupId, $body);
    }

    public function setMembers(UwGroup $group)
    {
        $body = new \stdClass();
        $body->data = $group->members->all();

        return $this->put($group->id . '/member', $body);
    }

    private function config(array $extraConfig)
    {
        return array_merge([
            'cert' => $this->certFile,
        ], $extraConfig);
    }

    private function get($relativeUri, $config = [])
    {
        $client = new GuzzleClient();
        return $client->request('GET', $this->uriBase . $relativeUri, $this->config($config));
    }

    private function put($relativeUri, $payload, $config = [])
    {
        $config = $this->config($config);
        $config['json'] = $config['json'] ?? $payload;
        $client = new GuzzleClient();
        return $client->request('PUT', $this->uriBase . $relativeUri, $config);
    }
}
