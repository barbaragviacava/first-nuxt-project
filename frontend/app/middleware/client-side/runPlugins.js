import runClientEveryPage from "../../plugins/runClientEveryPage"

export default context => {

    // Run after routes transitions
    if (process.browser) {

        runClientEveryPage(context)
    }
}
