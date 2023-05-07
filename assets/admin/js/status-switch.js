'use strict';
(function($) {
        // ============== status switch script ========== //////
        let status_switch = $('.__status_switch')

        ////===============if DOM has .__status_switch elemets==============
        if (status_switch.length > 0) {
            $(status_switch).each(function(index, item) {

                        ///===========get the acceories data from element attribiute
                        let action = $(item).attr('data-action') || "";
                        let heading = $(item).attr('data-heading') || "Change Status";
                        let message = $(item).attr('data-message') || "Are you sure change this status";
                        let status = $(item).attr('data-status') || 1;
                        let id = $(item).attr('data-id');

                        //===== if element has no data-id attribute, set a error message
                        if (!id) {
                            console.error("Must be need a unique data-id attribute")
                            return;
                        }

                        ///========== make a html
                        let html = `
                        <label for="staus_${id}" class="__switch">
                            <input id="staus_${id}" type="checkbox"
                                class="__status" data-message-heading="${heading}"
                                data-message="${message}"
                                data-url="${action}"
                                ${status == 1 ? `checked` : ``}
                                >
                            <span class="__slider" />
                        </label>
                `
            $(item).html(html)
        });
    
        //==================call modalAppendToBody funtion, which append a bootstrap modal for show warning message
        modalAppendToBody()
         }
         function modalAppendToBody(){
            let modal=`
            <div class="modal fade" id="__satus_modal" tabindex="-1" role="dialog" aria-labelledby="__modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="__satus_modal_label">Change Status</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <form method="get" action="">
                      
                        <input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">
                        <div class="modal-body">
                            <p class="text-muted" id="text-muted">Are you sure change this status</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn--primary" id="submitBtn">Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            `
            $(document).find('body').append(modal)
        }

         ///=====status change route======
         $(document).on('click', '.__status', function(e) {
            let modal=$(document).find('#__satus_modal')
            if (e.target.checked) {
                e.target.checked = false
            } else {
                e.target.checked = true
            }
            var url = $(this).attr("data-url");
            let msg = $(this).attr('data-message') || "Are you sure chnage this status?"
            let heading = $(this).attr('data-message-heading') || "Change Status"
            modal.find('form').attr('action', url);
            modal.find('#__satus_modal_label').text(heading);
            modal.find('#text-muted').text(msg);
            modal.modal('show')
           
        })



})(jQuery);