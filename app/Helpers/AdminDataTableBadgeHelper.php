<?php

namespace App\Helpers;

class AdminDataTableBadgeHelper
{
    public static function statusBadge($object): string
    {
        $status = '';
        if ((string) $object->status === 'Active') {
            $status = '<span class="badge bg-success text-success-fg status-change cursor-pointer" data-status="InActive" data-id="'.$object->id.'" >'.trans('messages.active').'</span>';
        } elseif ((string) $object->status === 'inactive') {
            $status = '<span class="badge bg-danger text-danger-fg status-change cursor-pointer" data-status="active" data-id="'.$object->id.'" >'.trans('messages.inactive').'</span>';
        } elseif ((string) $object->status === 'active') {
            $status = '<span class="badge bg-success text-success-fg status-change cursor-pointer" data-status="inActive" data-id="'.$object->id.'" >'.trans('messages.active').'</span>';
        } elseif ((string) $object->status === 'inActive') {
            $status = '<span class="badge bg-danger text-danger-fg status-change cursor-pointer" data-status="active" data-id="'.$object->id.'" >'.trans('messages.inactive').'</span>';
        } elseif ((string) $object->status === 'pending') {
            $status = '<span class="badge bg-warning text-warning-fg " data-status="active" data-id="'.$object->id.'" >'.trans('messages.pending').'</span>';
        } elseif ((string) $object->status === 'draft') {
            $status = '<span class="badge bg-danger text-danger-fg " data-status="active" data-id="'.$object->id.'" >'.trans('messages.draft').'</span>';
        } elseif ((string) $object->status === 'completed') {
            $status = '<span class="badge bg-success text-success-fg " data-status="active" data-id="'.$object->id.'" >'.trans('messages.completed').'</span>';
        } elseif ((string) $object->status === 'replied') {
            $status = '<span class="badge bg-info text-info-fg " data-status="active" data-id="'.$object->id.'" >'.trans('messages.replied').'</span>';
        }

        return $status;
    }

    public static function ecommerceStatusBadge($object): string
    {
        $status = '';
        if ((string) $object->status === 'published') {
            $status = '<span class="badge bg-info text-info-fg" data-status="published" data-id="'.$object->id.'" >'.trans('messages.published').'</span>';
        } elseif ((string) $object->status === 'draft') {
            $status = '<span class="badge bg-danger text-danger-fg" data-status="draft" data-id="'.$object->id.'" >'.trans('messages.draft').'</span>';
        } elseif ((string) $object->status === 'pending') {
            $status = '<span class="badge bg-warning text-warning-fg" data-status="pending" data-id="'.$object->id.'" >'.trans('messages.pending').'</span>';
        }

        return $status;
    }

    public static function imageWithName($url, $name, $link = 'javascript:void(0)')
    {
        return '<span>
        <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                    <div class="avatar-sm bg-light rounded p-1">
                    <img src="'.$url.'" alt="" class="img-fluid d-block">
                    </div>
                    </div>
                    <div class="flex-grow-1">
                    <h5 class="fs-14 mb-1">
                    <a href="'.$link.'" class="text-body">'.$name.'</a>
                    </h5>
                </div>
          </div>
       </span>';
    }
    public static function defaultBadge($donation): string
    {
        $status = $donation->is_slider_display ? 'Yes' : 'No';
        $statusClass = $donation->is_slider_display ? 'badge-soft-success' : 'badge-soft-danger';
        $newStatus = $donation->is_slider_display ? 0 : 1;
        $html = '<span class="badge ' . $statusClass . ' default-toggle cursor-pointer" data-id="' . $donation->id . '" data-status="' . $newStatus . '">';
        $html .= $status;
        $html .= '</span>';
        return $html;
    }
}
