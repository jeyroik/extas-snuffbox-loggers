<?php
namespace extas\components\loggers;

use extas\components\extensions\Extension;
use extas\components\extensions\ExtensionLogger;
use extas\components\repositories\TSnuffRepositoryDynamic;
use extas\components\THasMagicClass;

/**
 * Trait TSnuffLogging
 *
 * @package extas\components\loggers
 * @author jeyroik <jeyroik@gmail.com>
 */
trait TSnuffLogging
{
    use TSnuffRepositoryDynamic;
    use THasMagicClass;

    /**
     * @throws \Exception
     */
    public function turnSnuffLoggingOn()
    {
        $this->createSnuffDynamicRepositories([
            ['loggers', 'name', Logger::class]
        ]);

        $this->createWithSnuffRepo('extensionRepository', new Extension([
            Extension::FIELD__CLASS => ExtensionLogger::class,
            Extension::FIELD__SUBJECT => '*',
            Extension::FIELD__METHODS => [
                'emergency', 'alert', 'critical', 'warning', 'error', 'notice', 'info', 'debug', 'log'
            ]
        ]));

        $this->getMagicClass('loggers')->create(new Logger([
            Logger::FIELD__NAME => 'buffered',
            Logger::FIELD__CLASS => BufferLogger::class,
            Logger::FIELD__TAGS => ['test']
        ]));
    }

    public function turnSnuffLoggingOff(): void
    {
        BufferLogger::$log = [];
    }
}
