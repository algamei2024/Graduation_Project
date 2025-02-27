// import '../vendor/jquery/jquery.min.js'
import '../vendor/jquery/jquery'
// import '../vendor/bootstrap/js/bootstrap.bundle.min.js'
import '../vendor/bootstrap/js/bootstrap.bundle'
// import '../vendor/jquery-easing/jquery.easing.min.js'
import '../vendor/jquery-easing/jquery.easing'
// import '../js/sb-admin-2.min.js'
import '../js/sb-admin-2'
// import '../vendor/chart.js/Chart.min.js'
import '../vendor/chart.js/Chart'
// import '../js/demo/chart-area-demo.js'
import '../js/demo/chart-area-demo'
// import '../js/demo/chart-pie-demo.js'
import '../js/demo/chart-pie-demo'



export default function Footer() {
    // setTimeout(function () {
    //     $('.alert').slideUp();
    // }, 4000);

    let date = new Date();

    return (

        <div>
            <footer className="sticky-footer bg-white">
                <div className="container my-auto">
                    <div className="copyright text-center my-auto">
                        <span>
                            component Footer
                            <a href="https://github.com/Prajwal100" target="_blank">Prajwal R.</a>
                        </span>
                    </div>
                </div>
            </footer>
            <a className="scroll-to-top rounded" href="#page-top">
                {/* <i className="fas fa-angle-up" /> */}
            </a>
            <div className="modal fade" id="logoutModal" tabIndex={-1} role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div className="modal-dialog" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button className="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div className="modal-footer">
                            <button className="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a className="btn btn-primary" href="login.html">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    );
}
