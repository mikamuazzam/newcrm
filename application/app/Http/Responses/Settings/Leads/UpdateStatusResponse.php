<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [update] process for the leads settings
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Leads;
use Illuminate\Contracts\Support\Responsable;

class UpdateStatusResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for leadsources
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //replace the row of this record
        $html = view('pages/settings/sections/leads/table/ajax', compact('statuses'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => "#status_" . $statuses->first()->leadstatus_id,
            'action' => 'replace-with',
            'value' => $html);

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

}
