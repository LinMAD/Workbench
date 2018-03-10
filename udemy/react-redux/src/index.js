import React from "react";
import ReactDOM from "react-dom";

import SearchBar from "./Components/search_bar";

// Key for Youtube v3 API, restricted by IP
const Y_API_KEY = 'AIzaSyC2zRFqFVwOqJB1Vl2NNpYJ96NirRuL3X4';

const App = () => {
  return (
      <div>
          <SearchBar/>
      </div>
  );
};

ReactDOM.render(
    <App/>,
    document.querySelector('.container')
);
