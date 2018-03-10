import React from "react";
import {Component} from "react/lib/ReactIsomorphic";

class SearchBar extends Component {
    render() {
        return <input onChange={SearchBar.onInputChange} />;
    }

    static onInputChange(event) {
        console.log(event.target.value)
    }
}

export default SearchBar;
