<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Routes\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

class PhoneNumberContext extends InstanceContext {
    /**
     * Initialize the PhoneNumberContext
     *
     * @param Version $version Version that contains the resource
     * @param string $phoneNumber The phone number
     */
    public function __construct(Version $version, $phoneNumber) {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['phoneNumber' => $phoneNumber, ];

        $this->uri = '/PhoneNumbers/' . \rawurlencode($phoneNumber) . '';
    }

    /**
     * Create the PhoneNumberInstance
     *
     * @param array|Options $options Optional Arguments
     * @return PhoneNumberInstance Created PhoneNumberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(array $options = []): PhoneNumberInstance {
        $options = new Values($options);

        $data = Values::of([
            'VoiceRegion' => $options['voiceRegion'],
            'FriendlyName' => $options['friendlyName'],
        ]);

        $payload = $this->version->create('POST', $this->uri, [], $data);

        return new PhoneNumberInstance($this->version, $payload, $this->solution['phoneNumber']);
    }

    /**
     * Update the PhoneNumberInstance
     *
     * @param string $voiceRegion The Inbound Processing Region used for this phone
     *                            number for voice
     * @param string $friendlyName A human readable description of this resource.
     * @return PhoneNumberInstance Updated PhoneNumberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(string $voiceRegion, string $friendlyName): PhoneNumberInstance {
        $data = Values::of(['VoiceRegion' => $voiceRegion, 'FriendlyName' => $friendlyName, ]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new PhoneNumberInstance($this->version, $payload, $this->solution['phoneNumber']);
    }

    /**
     * Fetch the PhoneNumberInstance
     *
     * @return PhoneNumberInstance Fetched PhoneNumberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): PhoneNumberInstance {
        $payload = $this->version->fetch('GET', $this->uri);

        return new PhoneNumberInstance($this->version, $payload, $this->solution['phoneNumber']);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Routes.V2.PhoneNumberContext ' . \implode(' ', $context) . ']';
    }
}