/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {
    blog_form.init();
});

blog_form = function () {
    return {
        init: function () {

            blog_form.addEvents(jQuery('body'));

        }, addEvents: function (html) {

            html.find('.latest_blogs_block .nav li a').click(function () {

                var category_id = jQuery(this).attr('category_id');

                blog_form.loadCategoryBlogs(category_id);
            });

            return html;

        }, loadCategoryBlogs: function (category_id) {

            var data_object = {category_id: category_id};

            var form = kazist.callAjaxByRoute('cms.blogs.ajaxloadcategoryblogs', data_object, true);

            jQuery('.category-blogs').html('Please Wait. Loading');
            kazist.addSpinningIcon(jQuery('.category-blogs'));

            jQuery('.category-blogs').html(form);

        }
    };
}();