<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\oauth\utility\ZohoOAuthTokens;
use zcrmsdk\oauth\persistence\ZohoOAuthPersistenceByFile;

class ZohoOAuthPersistenceByFileTest extends TestCase {

    private $config;
    private $persist;
    static $tokenfile = __DIR__ . '/zcrm_oauthtokens.txt';

    public function setUp(): void
    {
        $this->config['currentUserEmail'] = 'example@zoho.com';
        $this->config['token_persistence_path'] = dirname(self::$tokenfile) . '/';
        ZohoOAuth::initialize($this->config);

        $this->persist = new ZohoOAuthPersistenceByFile();
        self::$tokenfile = $this->persist->tokenfile;
    }

    public static function tearDownAfterClass(): void
    {
        if (is_file(self::$tokenfile)) {
            unlink(self::$tokenfile);
        }
    }

    public function testReadEmpty()
    {
        $this->assertIsWritable(dirname(self::$tokenfile), "Could not write to TokenFile Path: " . dirname(self::$tokenfile));

        if (is_file(self::$tokenfile)) {
            unlink(self::$tokenfile);
        }

        $this->expectException(Exception::class);
        $this->persist->getOAuthTokens($this->config['currentUserEmail']);
    }

    public function testWrite()
    {

        $oAuthTokens = new ZohoOAuthTokens();
        $oAuthTokens->setExpiryTime($oAuthTokens->getCurrentTimeInMillis() + 86400);
        $oAuthTokens->setAccessToken('1000.' . md5(microtime(true) . '1') . '.' . md5(microtime(true) . '2'));
        $oAuthTokens->setRefreshToken('1000.' . md5(microtime(true) . '3') . '.' . md5(microtime(true) . '4'));
        $oAuthTokens->setUserEmailId($this->config['currentUserEmail']);

        $this->persist->saveOAuthData($oAuthTokens);

        $filename = realpath(self::$tokenfile);
        $this->assertIsString($filename);
        $this->assertFileIsReadable($filename);
        $tokenContent = file_get_contents($filename);
        $arr = unserialize($tokenContent);
        $this->assertIsArray($arr);
        foreach($arr as $token) {
            $this->assertThat(
                $token,
                $this->IsInstanceOf("zcrmsdk\oauth\utility\ZohoOAuthTokens")
            );
            $this->assertIsString($token->getAccessToken());
        }
    }

    /**
     * @depends testWrite
     */
    public function testReadAfterWrite()
    {
        $token = $this->persist->getOAuthTokens($this->config['currentUserEmail']);
        $this->assertThat(
            $token,
            $this->IsInstanceOf("zcrmsdk\oauth\utility\ZohoOAuthTokens")
        );
        $this->assertIsString($token->getAccessToken());
    }

}
