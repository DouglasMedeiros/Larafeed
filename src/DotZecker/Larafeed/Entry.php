<?php namespace DotZecker\Larafeed;

use Validator;
use Carbon\Carbon;
use DotZecker\Larafeed\Exceptions\EntryException;

class Entry {

    public $title;

    public $link;

    public $author;

    public $pubDate;

    public $updated;

    public $summary;

    public $content;

    public $format = 'atom';

    /**
     * Fill attributes
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        foreach ($data as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    /**
     * Validate, autofill and sanitize the entry
     * @return void
     */
    public function prepare()
    {
        // The date format method to use with Carbon to convert the dates
        $dateFormatMethod = 'to' . strtolower($this->format) . 'String';

        // Set the good date format to the publication date
        if ( ! is_null($this->pubDate))
            $this->pubDate = Carbon::parse($this->pubDate)->{$dateFormatMethod}();

        // Set the good date format to the publication last updated date
        if ( ! is_null($this->updated))
            $this->updated = Carbon::parse($this->updated)->{$dateFormatMethod}();

        // Remove tags (In case it had)
        $this->title = strip_tags($this->title);

        // Fill the attributes that can be autogenerated
        $this->autoFill();
    }

    /**
     * Fill the attributes that can be autogenerated
     * @return void
     */
    public function autoFill()
    {
        // The date format method to use with Carbon to convert the dates
        $dateFormatMethod = 'to' . strtolower($this->format) . 'String';

        // Set the 'now' date
        if (is_null($this->pubDate))
            $this->pubDate = Carbon::parse('now')->{$method}();

        // Generate the summary
        if (is_null($this->summary)) {
            $summary = strip_tags($this->content);

            // @todo: Get lenght by config
            $this->summary = substr($summary, 0, 144) . '...';
        }

    }

    /**
     * Validate the entry
     * @return boolean
     */
    public function isValid()
    {
        $data = get_object_vars($this);

        $rules = array(
            'format'      => 'required|in:atom,rss',
            'link'        => 'required|url',
            'title'       => 'required',
            'pubDate'     => 'required|date',
            'author'      => 'required',
            'content'     => 'required'
        );

        if (isset($this->updated)) $rules['updated'] = 'date';

        $validator = Validator::make($data, $rules);

        // @todo: By config decide to throw the exception or return just ignore malformated entries
        if ($validator->fails())
            throw new EntryException($validator->errors()->first());

        return true;
    }

}

