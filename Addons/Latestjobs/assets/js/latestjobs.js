/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {
    job_form.init();
});

job_form = function () {
    return {
        init: function () {

            job_form.addEvents(jQuery('body'));

        }, addEvents: function (html) {

            html.find('.latest_jobs_block .nav li a').click(function () {

                var category_id = jQuery(this).attr('category_id');

                job_form.loadCategoryBlogs(category_id);
            });

            return html;

        }, loadCategoryBlogs: function (category_id) {

            var data_object = {category_id: category_id};

            var form = kazist.callAjaxByRoute('jobs.jobs.ajaxloadcategoryjobs', data_object, true);

            jQuery('.category-jobs').html('Please Wait. Loading');
            kazist.addSpinningIcon(jQuery('.category-jobs'));

            jQuery('.category-jobs').html(form);

        }
    };
}();