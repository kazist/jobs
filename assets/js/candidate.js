/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {
    candidate.init();
});

candidate = function () {
    return {
        init: function () {

            candidate.addEvents(jQuery('body'));

        }, addEvents: function (html) {

            html.find('.delete-document-tr').on('click', function () {
                candidate.deleteDocumentTr(jQuery(this));
            });

            html.find('.add-document-tr').on('click', function () {
                candidate.addDocumentTr(jQuery(this));
            });

            html.find('.edit-education').on('click', function () {
                candidate.editEducation(jQuery(this));
            });

            html.find('.add-education').on('click', function () {
                candidate.addEducation(jQuery(this));
            });

            html.find('.delete-education').on('click', function () {
                return candidate.deleteEducation(jQuery(this));
            });

            html.find('.edit-experience').on('click', function () {
                candidate.editExperience(jQuery(this));
            });

            html.find('.add-experience').on('click', function () {
                candidate.addExperience(jQuery(this));
            });

            html.find('.delete-experience').on('click', function () {
                return candidate.deleteExperience(jQuery(this));
            });

            html.find(".jobs-navigation a").on('click', function (event) {
                candidate.loadFaqs(jQuery(this));
            });

            html.find('.photo-input').each(function () {
                candidate.photoClickEvent(jQuery(this));
            });

            html.find(".country_id").on('change', function (event) {
                candidate.loadLocations(jQuery(this));
            });

            html.find(".save-profile").on('click', function (event) {
                jQuery(this).closest('form').submit();
            });

            return html;

        }, loadFaqs: function (this_element) {

            var action = this_element.attr('action');
            var offset = this_element.attr('offset');
            var category_id = this_element.attr('category_id');
            var data_object = {action: action, offset: offset, category_id: category_id};

            var form = kazist.callAjaxByRoute('jobs.jobs.ajaxloadjobs', data_object, true);

            jQuery('.category-jobs-listing').html(form);

            candidate.addEvents(jQuery('.category-jobs-listing'));

        }, photoClickEvent: function (this_element) {

            this_element.find('.photo-wrapper').on('click', function (e) {

                var upload_photo = this_element.closest('.photo').find('.upload_photo');
                upload_photo.click();
                candidate.addNewPhotoDiv();
            });

            this_element.find('.upload_photo').on('change', function (e) {
                candidate.uploadInputChanged(this, jQuery(this));
            });

        }, addEducation: function (this_element) {

            jQuery('.candidate-education-form input#education_institution').val('');
            jQuery('.candidate-education-form input#education_field_of_study').val('');
            jQuery('.candidate-education-form input#education_grade').val('');
            jQuery('.candidate-education-form input#education_activities').val('');
            jQuery('.candidate-education-form textarea#education_description').val('');
            jQuery('.candidate-education-form input#education_start_date').val('');
            jQuery('.candidate-education-form input#education_end_date').val('');

        }, editEducation: function (this_element) {

            var main_div = this_element.closest('.single-candidate-education');

            var id = main_div.find('.educaction_id').attr('education_data');
            var institution = main_div.find('.institution').attr('education_data');
            var certification_id = main_div.find('.certification_id').attr('education_data');
            var field_of_study = main_div.find('.field_of_study').attr('education_data');
            var grade = main_div.find('.grade').attr('education_data');
            var activities = main_div.find('.activities').attr('education_data');
            var description = main_div.find('.description').attr('education_data');
            var start_date = main_div.find('.start_date').attr('education_data');
            var end_date = main_div.find('.end_date').attr('education_data');

            jQuery('.candidate-education-form .education_id').val(id);
            jQuery('.candidate-education-form .education_institution').val(institution);
            jQuery('.candidate-education-form .education_certification_id').val(certification_id);
            jQuery('.candidate-education-form .education_field_of_study').val(field_of_study);
            jQuery('.candidate-education-form .education_grade').val(grade);
            jQuery('.candidate-education-form .education_activities').val(activities);
            jQuery('.candidate-education-form .education_description').val(description);
            jQuery('.candidate-education-form .education_start_date').val(start_date);
            jQuery('.candidate-education-form .education_end_date').val(end_date);

        }, deleteEducation: function (this_element) {

            var is_confirm = confirm('Are you sure You want to Delete');

            return is_confirm;

        }, addExperience: function (this_element) {

            jQuery('.candidate-experience-form input#experience_title').val('');
            jQuery('.candidate-experience-form textarea#experience_description').val('');
            jQuery('.candidate-experience-form input#experience_company').val('');
            jQuery('.candidate-experience-form input#experience_location').val('');
            jQuery('.candidate-experience-form input#experience_position').val('');
            jQuery('.candidate-experience-form input#experience_start_date').val('');
            jQuery('.candidate-experience-form input#experience_end_date').val('');

        }, editExperience: function (this_element) {

            var main_div = this_element.closest('.single-candidate-experience');

            var id = main_div.find('.experience_id').attr('experience_data');
            var title = main_div.find('.title').attr('experience_data');
            var description = main_div.find('.description').attr('experience_data');
            var company = main_div.find('.company').attr('experience_data');
            var location = main_div.find('.location').attr('experience_data');
            var position = main_div.find('.position').attr('experience_data');
            var start_date = main_div.find('.start_date').attr('experience_data');
            var end_date = main_div.find('.end_date').attr('experience_data');

            jQuery('.candidate-experience-form .experience_id').val(id);
            jQuery('.candidate-experience-form .experience_title').val(title);
            jQuery('.candidate-experience-form .experience_description').val(description);
            jQuery('.candidate-experience-form .experience_company').val(company);
            jQuery('.candidate-experience-form .experience_location').val(location);
            jQuery('.candidate-experience-form .experience_position').val(position);
            jQuery('.candidate-experience-form .experience_start_date').val(start_date);
            jQuery('.candidate-experience-form .experience_end_date').val(end_date);

        }, deleteExperience: function (this_element) {

            var is_confirm = confirm('Are you sure You want to Delete');

            return is_confirm;

        }, deleteDocumentTr: function (this_element) {

            var is_confirm = confirm('Are you sure You want to Delete');

            if (is_confirm) {

                var document_id = this_element.attr('document_id');
                var candidate_id = this_element.attr('candidate_id');
                var data_object = {document_id: document_id, candidate_id: candidate_id};

                var form = kazist.callAjaxByRoute('jobs.candidates.ajaxdeletedocument', data_object, true);

                candidate.loadCandidate(candidate_id, document_id);

                this_element.closest('tr').remove();
            }

        }, addDocumentTr: function (this_element) {

            var html = '';

            html += '<tr>';
            html += '<td>';
            html += '<input type="text" name="form[document][new][title][]" value="">';
            html += '</td>';
            html += '<td>';
            html += '<input type="file" name="form[document][new][upload][]">';
            html += '</td>';
            html += '<td>';
            html += ' <a class="btn btn-danger btn-xs btn-flat delete-document-tr">';
            html += '<i class="fa fa-times"></i>';
            html += '</a>';
            html += '</td>';
            html += '</tr>';

            html = jQuery(html);

            this_element.closest('.candidate-documents-form').find('table tbody').append(html);

            candidate.addEvents(html);


        }, uploadInputChanged: function (this_element, jquery_this_element) {

            if (this_element.files && this_element.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    //  $('#blah').attr('src', e.target.result);
                    var image_src = '<img src="' + e.target.result + '">';
                    jquery_this_element.closest('.photo').find('.photo-wrapper').html(image_src);
                };

                reader.readAsDataURL(this_element.files[0]);
            }
        }, loadLocations: function (this_element) {

            var country_id = this_element.val();
            var data_object = {country_id: country_id};

            var form = kazist.callAjaxByRoute('jobs.jobs.ajaxloadlocations', data_object, true);

            jQuery('.location_id').html(form);

        }, loadCandidate: function (candidate_id, document_id) {

            var data_object = {candidate_id: candidate_id, document_id: document_id};

            var form = kazist.callAjaxByRoute('jobs.candidates.ajaxloadcandidates', data_object, true);

            jQuery('.candidate-documents-form').html(form);

            candidate.addEvents(jQuery('.candidate-documents-form'));
        }

    };
}();