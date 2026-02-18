import { createStore } from "Vuex";
import watchlist from "./modules/watchlist";

export default createStore({
    modules: {
        watchlist,
    },
});
