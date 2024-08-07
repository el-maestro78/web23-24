/**
 * 
 * @param {JSON} data contains the request or offer json
 * @returns string
 */
function getDataColor(data) {
    //console.log(data);
    if(data.pending !== "t") return "green" //'red';
    else return "red";//'yellow';
    //return data.pending ? "red" : "yellow";
}

function vehiclePopup(data){
    return `<b>Vehicle ID: ${data.username}</b>`;
}

function offerPopup(data) {
    return `<b>Offer ID: ${data.off_id}</b>`;
}

async function requestPopup(data) {
    let full_name = "";
    let phone = "";
    let item_name = "";
    let vehUsername = "";
    try {
        const userResponse = await fetch(`../../controller/admin/fetch_user_by_id.php?user_id=${encodeURIComponent(data.userId)}`);
        const itemResponse = await fetch(`../../controller/admin/fetch_item_by_id.php?item_id=${encodeURIComponent(data.item_id)}`);
        
        const userData = await userResponse.json();
        full_name = `${userData.first_name} ${userData.surname}`;
        phone = userData.phone;

        const itemData = await itemResponse.json();
        item_name = itemData.iname;
        
        if (data.pending !== "t"){
            const vehResponse = await fetch(`../../controller/admin/fetch_loaded_veh.php?veh_id=${encodeURIComponent(data.item_id)}`);
            const vehData = await vehResponse.json();
            vehUsername = vehData.username;
        }
    }catch(error){
        console.error("Error fetching user or item data: ", error);
    }

  return `
        <b>Request</b><br>
        <b>Ονοματεπώνυμο:</b> ${full_name}<br>
        <b>Τηλέφωνο:</b> ${phone}<br>
        <b>Ημερομηνία Καταχώρησης:</b> ${data.reg_date}<br>
        <b>Είδος:</b> ${item_name}<br>
        <b>Ποσότητα:</b> ${data.quantity}<br>
        <b>Ημερομηνία Ανάληψης:</b> ${data.pending !== "t" ? data.assign_date : "N/A"}<br>
        <b>Username Οχήματος:</b> ${data.pending !== "t" ? vehUsername : "N/A"}
    `;
}


