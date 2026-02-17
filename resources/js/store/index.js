import { createStore } from "vuex";
import watchlist from "./modules/watchlist";

export default createStore({
    modules: {
        watchlist,
    },
});
