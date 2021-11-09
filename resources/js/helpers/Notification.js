class Notification{
    success(){
        new Noty({
            type:'success',
            layout:"topRight",
            text: 'Successfully Done',
            timeout:1000,
        }).show();
    };

    alert(){
        new Noty({
            type:'alert',
            layout:"topRight",
            text: 'Are you sure?',
            timeout:1000,
        }).show();
    };


    warning(){
        new Noty({
            type:'warning',
            layout:"topRight",
            text: 'Opps!',
            timeout:1000,
        }).show();
    };


    error(){
        new Noty({
            type:'error',
            layout:"topRight",
            text: 'Something went wrong',
            timeout:1000,
        }).show();
    };
    image_validation(){
        new Noty({
            type:'error',
            layout:"topRight",
            text: 'Image size should be less than 1 mb',
            timeout:1000,
        }).show();
    };
    addToCart(){
        new Noty({
            type:'success',
            layout:"topRight",
            text: 'Add to Cart Successfully!',
            timeout:1000,
        }).show();
    };
    delete(){
        new Noty({
            type:'success',
            layout:"topRight",
            text: 'Delete Successfully',
            timeout:1000,
        }).show();
    };

}
export default Notification = new Notification();