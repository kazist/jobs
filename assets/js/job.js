/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {
    job.init();
});

job = function () {
    return {
        init: function () {

            job.addEvents(jQuery('body'));

        }, addEvents: function (html) {

            html.find(".jobs-navigation a").on('click', function (event) {
                job.loadFaqs(jQuery(this));
            });

            html.find('.photo-input').each(function () {
                job.photoClickEvent(jQuery(this));
            });

            html.find(".country_id").on('change', function (event) {
                job.loadLocations(jQuery(this));
            });

            return html;

        }, loadFaqs: function (this_element) {

            var action = this_element.attr('action');
            var offset = this_element.attr('offset');
            var category_id = this_element.attr('category_id');
            var data_object = {action: action, offset: offset, category_id: category_id};

            var form = kazist.callAjaxByRoute('jobs.jobs.ajaxloadjobs', data_object, true);

            jQuery('.category-jobs-listing').html(form);

            job.addEvents(jQuery('.category-jobs-listing'));

        }, photoClickEvent: function (this_element) {

            this_element.find('.photo-wrapper').on('click', function (e) {

                var upload_photo = this_element.closest('.photo').find('.upload_photo');
                upload_photo.click();
                business_photos.addNewPhotoDiv();
            });

            this_element.find('.upload_photo').on('change', function (e) {
                job.uploadInputChanged(this, jQuery(this));
            });
        }, uploadInputChanged: function (this_element, jquery_this_element) {
            {


                if (this_element.files && this_element.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        //  $('#blah').attr('src', e.target.result);
                        var image_src = '<img src="' + e.target.result + '">';
                        jquery_this_element.closest('.photo').find('.photo-wrapper').html(image_src);
                    };

                    reader.readAsDataURL(this_element.files[0]);
                }
            }
        }, loadLocations: function (this_element) {

            var country_id = this_element.val();
            var data_object = {country_id: country_id};

            var form = kazist.callAjaxByRoute('jobs.jobs.ajaxloadlocations', data_object, true);

            jQuery('.location_id').html(form);
        }

    };
}();