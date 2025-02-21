export default function Loading({ fullPage = true }) {
    return (
        <div style={fullPage ? styles.fullPageContainer : styles.container}>
            <div style={styles.spinner} role="status">
                <span style={styles.visuallyHidden}>Loading...</span>
            </div>
        </div>
    );
}

const styles = {
    fullPageContainer: {
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        height: "100vh",
        width: "100vw",
        position: "fixed",
        top: 0,
        left: 0,
        backgroundColor: "rgba(255, 255, 255, 0.8)",
        zIndex: 9999,
    },
    container: {
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        width: "100%",
        height: "100%",
    },
    spinner: {
        width: "3rem",
        height: "3rem",
        borderWidth: "0.3rem",
        borderColor: "rgba(0, 0, 0, 0.1)",
        borderTopColor: "#000",
        borderStyle: "solid",
        borderRadius: "50%",
        animation: "spin 1s linear infinite",
    },
    visuallyHidden: {
        position: "absolute",
        width: "1px",
        height: "1px",
        margin: "-1px",
        padding: "0",
        overflow: "hidden",
        clip: "rect(0, 0, 0, 0)",
        border: "0",
    },
};

