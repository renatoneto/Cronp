<?php
namespace Cronp\Persist;

use Cronp\Schedule\Collection;

class StreamPersist implements SchedulePersist
{

    protected $stream;

    public function __construct($stream)
    {
        if (!is_resource($stream) || get_resource_type($stream) !== 'stream') {
            throw new \InvalidArgumentException('StreamPersist needs a stream');
        }

        $this->stream = $stream;
    }

    public function save(Collection $schedules)
    {
        @ftruncate($this->stream, 0);

        if (@fwrite($this->stream, serialize($schedules)) === false) {
            throw new \RuntimeException('Unable to write schedules stream');
        }

        fflush($this->stream);

        return true;
    }

    /**
     * @return Collection
     * @throws \RuntimeException
     */
    public function load()
    {
        rewind($this->stream);

        if (($content = @stream_get_contents($this->stream)) === false) {
            throw new \RuntimeException('Unable to read schedules stream');
        }

        $content = unserialize($content);

        if (!$content) {
            $content = new Collection();
        }

        return $content;
    }

}