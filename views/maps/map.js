/**
 * 
 * @param {JSON} data contains the request or offer json
 * @returns string
 */
function getDataColor(data) {
    console.log(data);
    if(data.pending !== "t") return "green" //'red';
    else return "red";//'yellow';
    //return data.pending ? "red" : "yellow";
}
