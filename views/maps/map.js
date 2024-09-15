/*
* Auxiliary functions in order to reduce complexity from maps.php
*
*/
/**
 * 
 * @param {JSON} data contains the request or offer json
 * @returns string
 */
function getDataColor(data) {
    if(data.pending !== "t") return "green";
    else return "red";
}

function getDataType(data) {
    if(data.pending !== "t") return "assigned"
    else return "pending";
}

function getVehColor(data) {
    vehicleTasks(data).then(result => {
        const { vehStatus} = result;
        /*
        if(vehStatus === 1) return "blue";
        else return "gray"; */

        return vehStatus === 1 ? "blue" : "gray";
    }).catch(error => {
        console.error("Error occurred while fetching vehicle data: ", error);});
        return '';
}

function getVehType(data) {
    //const {vehStatus} = vehicleTasks(data);
    vehicleTasks(data).then(result => {
        const { vehStatus} = result;
        if(vehStatus === 1) return "assigned";
        else return "pending";
    }).catch(error => {
        console.error("Error occurred while fetching vehicle data: ", error);});
        return '';
}

async function storedrag(event, base_id){
    let marker = event.target;
    let position = marker.getLatLng();
    let lat = position.lat;
    let long = position.lng;

    marker.setLatLng(position, {
        draggable: true
    }).update();
    try {
      fetch(
        `../../controller/admin/update_store_pos.php?base_id=${encodeURIComponent(base_id)}
        &lat=${encodeURIComponent(lat)}
        &long=${encodeURIComponent(long)}`
      );
    } catch (error) {
      console.error("Error storing store data:", error);
    }

}

async function vehicleDrag(event, veh_id){
    let marker = event.target;
    let position = marker.getLatLng();
    let lat = position.lat;
    let long = position.lng;
    marker.setLatLng(position, {
        draggable: true
    }).update();
    try {
        const params = new URLSearchParams();
        params.append("vehicle_id", veh_id);
        params.append("lat", lat);
        params.append("long", long);
        fetch('../../controller/rescuer/update_vehicle_pos.php', {
            method:'POST',
            body:params
        }).catch(error=>console.log(error))
    } catch (error) {
      console.error("Error storing store data:", error);
    }

}

async function vehiclePopup(data){
    const {vehLoad, vehTasks, vehStatus, vehItems, itemsHtml } = await vehicleTasks(data);
    let username;
    if(data.username === undefined){
        username = 'N/A';
    }else{
        username = data.username;
    }
    return `
        <div>
            <b>Vehicle</b><br>
            <b>Rescuer's Username:</b> ${username}<br><hr>
            ${itemsHtml}
            <b>Status:</b> ${vehStatus ? "On road" : "Idle"}<br>
            <b>Tasks:</b> ${vehTasks || "N/A"}<br>
        </div>`;
}

async function vehicleTasks(data){
    let vehLoad = "";
    let vehItems = "";
    let vehTasks = "";
    let itemsHtml = "";
    try{
        const vehResponse = await fetch(
          `../../controller/admin/fetch_vehicle_popup.php?veh_id=${encodeURIComponent(
            data.veh_id
          )}&timestamp=${new Date().getTime()}`
        );
        if (!vehResponse.ok) throw new Error("Failed to fetch vehicle data");
        const vehData = await vehResponse.json();
        //example {"task_count":"1","load_data":[{"load":"5","iname":"spam, eggs & spam"}]}
        //console.log(vehData);
        if (vehData.load_data && vehData.load_data.length > 0) {
          vehData.load_data.forEach((item) => {
            itemsHtml += `<b>Item:</b> ${item.iname || "N/A"}<br>
                          <b>Load:</b> ${item.load || "N/A"}<br><hr>`;
          });
          vehTasks = vehData.task_count;
        } else {
            vehLoad = vehData.load_data.load;
            vehItems = vehData.load_data.iname;
            itemsHtml += `<b>Item:</b> ${vehItems || "N/A"}<br>
                          <b>Load:</b> ${vehLoad || "N/A"}<br><hr>`;
            vehTasks = vehData.task_count;
        }
        if (vehTasks >= 1) vehStatus = 1;
        else vehStatus = 0;
    }catch (error) {
        console.error("Error fetching vehicle data: ", error);
        return ''
    }
    return {vehLoad, vehTasks, vehStatus, vehItems, itemsHtml};
}

async function offerPopup(data) {
    let full_name = "";
    let phone = "";
    let item_name = "";
    let vehUsername = "";

    try {
        const userResponse = await fetch(`../../controller/admin/fetch_user_by_id.php?user_id=${encodeURIComponent(data.user_id)}`);
        const itemResponse = await fetch(`../../controller/admin/fetch_item_by_id.php?item_id=${encodeURIComponent(data.item_id)}`);

        const userData = await userResponse.json();
        if (userData.length > 0) {
          full_name = `${userData[0].first_name} ${userData[0].surname}`;
          phone = userData[0].phone;
        }else{
            full_name = `${userData.first_name} ${userData.surname}`;
            phone = userData.phone;
        }
        if (!itemResponse.ok) throw new Error("Failed to fetch item data");
        const itemData = await itemResponse.json();
        if (itemData.length > 0) {
          item_name = itemData[0].iname;
        } else {
          item_name = itemData.iname;
        }//console.log(item_name);
        
        if (data.pending !== "t"){
            const vehResponse = await fetch(`../../controller/admin/fetch_veh_off_id.php?off_id=${encodeURIComponent(data.off_id)}`);
            if (!vehResponse.ok) throw new Error("Failed to fetch vehicle data");
            const vehData = await vehResponse.json();
            //console.log(vehData)
            if (vehData.length > 0) {
                vehUsername = vehData[0].username;
                
            } else {
                vehUsername = vehData.username;
            } //console.log(vehUsername);
        }
    }catch(error){
        console.error("Error fetching offer data for popup: ", error);
    }
  return `<div>
        <b>Offer</b><br>
        <b>Ονοματεπώνυμο:</b> ${full_name}<br>
        <b>Τηλέφωνο:</b> ${phone}<br>
        <b>Ημερομηνία Καταχώρησης:</b> ${data.reg_date}<br>
        <b>Είδος:</b> ${item_name}<br>
        <b>Ποσότητα:</b> ${data.quantity}<br>
        <b>Ημερομηνία Ανάληψης:</b> ${
          data.pending !== "t" ? data.assign_date : "N/A"
        }<br>
        <b>Rescuer's Username:</b> ${data.pending !== "t" ? vehUsername : "N/A"}
    </div>
        `;  
}

async function requestPopup(data) {
    let full_name = "";
    let phone = "";
    let item_name = "";
    let vehUsername = "";

    try {
        const userResponse = await fetch(`../../controller/admin/fetch_user_by_id.php?user_id=${encodeURIComponent(data.user_id)}`);
        const itemResponse = await fetch(`../../controller/admin/fetch_item_by_id.php?item_id=${encodeURIComponent(data.item_id)}`);

        const userData = await userResponse.json();
        if (userData.length > 0) {
          full_name = `${userData[0].first_name} ${userData[0].surname}`;
          phone = userData[0].phone;
        }else{
            full_name = `${userData.first_name} ${userData.surname}`;
            phone = userData.phone;
        }
        

        if (!itemResponse.ok) throw new Error("Failed to fetch item data");
        const itemData = await itemResponse.json();
        if (itemData.length > 0) {
          item_name = itemData[0].iname;
        } else {
          item_name = itemData.iname;
        }//console.log(item_name);
        
        if (data.pending !== "t"){
            const vehResponse = await fetch(`../../controller/admin/fetch_loaded_veh.php?req_id=${encodeURIComponent(data.req_id)}`);
            if (!vehResponse.ok) throw new Error("Failed to fetch vehicle data");
            const vehData = await vehResponse.json();
            //console.log(vehData)
            if (vehData.length > 0) {
                vehUsername = vehData[0]['username'];
            } else {
                vehUsername = vehData.username;
            } //console.log(vehUsername);
        }
    }catch(error){
        console.error("Error fetching request data for popup: ", error);
    }
  return `<div>
        <b>Request</b><br>
        <b>Ονοματεπώνυμο:</b> ${full_name}<br>
        <b>Τηλέφωνο:</b> ${phone}<br>
        <b>Ημερομηνία Καταχώρησης:</b> ${data.reg_date}<br>
        <b>Είδος:</b> ${item_name}<br>
        <b>Ποσότητα:</b> ${data.quantity}<br>
        <b>Ημερομηνία Ανάληψης:</b> ${
          data.pending !== "t" ? data.assign_date : "N/A"
        }<br>
        <b>Rescuer's Username:</b> ${data.pending !== "t" ? vehUsername : "N/A"}
    </div>
        `;  
}

async function getVehicleTasks(id){
    const taskResp = await fetch(`../../controller/admin/fetch_tasks_for_line.php?veh_id=${encodeURIComponent(id)}&timestamp=${new Date().getTime()}`);
    const taskData = await taskResp.json();
    //console.log(taskData)
    let tasks = [];
    if (taskData.offers.length > 0){
        taskData.offers.forEach((offer) => {
        tasks.push({ ...offer});
        });
    }
    if (taskData.requests.length > 0) {
      taskData.requests.forEach((request) => {
        tasks.push({ ...request});
      });
    }
    return tasks;
}

async function rescuersTasks(id) {
    return await (await fetch(`../../controller/rescuer/get_my_tasks.php?veh_id=${encodeURIComponent(id)}&timestamp=${new Date().getTime()}`)).json();
}

async function drawVehicleLine(marker, tasksProm) {
    try{
        const tasks = await tasksProm;
        if (tasks.length <= 0) {
          //console.log("Nothing");
          return;
        }
        //console.log(tasks);
        tasks.forEach((task) => {
          const taskLatLng = [task.lat, task.long];
          const polyline = L.polyline([marker.getLatLng(), taskLatLng], { color: "blue" }).addTo(
            map
          );
          polyline.addTo(polylineLayerGroup);
        });
    }catch{
        if (tasks.length <= 0) {
          console.log("Nothing");
          return;
        }
        console.log(tasks);
        tasks.forEach((task) => {
          const taskLatLng = [task.lat, task.long];
          L.polyline([marker.getLatLng(), taskLatLng], { color: "blue" }).addTo(
            map
          );
        });
    }
    
}

async function offerPopupRescuer(data) {
    let full_name = "";
    let phone = "";
    let item_name = "";
    let vehUsername = "";

    try {
        const userResponse = await fetch(`../../controller/admin/fetch_user_by_id.php?user_id=${encodeURIComponent(data.user_id)}`);
        const itemResponse = await fetch(`../../controller/admin/fetch_item_by_id.php?item_id=${encodeURIComponent(data.item_id)}`);

        const userData = await userResponse.json();
        if (userData.length > 0) {
          full_name = `${userData[0].first_name} ${userData[0].surname}`;
          phone = userData[0].phone;
        }else{
            full_name = `${userData.first_name} ${userData.surname}`;
            phone = userData.phone;
        }
        if (!itemResponse.ok) throw new Error("Failed to fetch item data");
        const itemData = await itemResponse.json();
        if (itemData.length > 0) {
          item_name = itemData[0].iname;
        } else {
          item_name = itemData.iname;
        }//console.log(item_name);

        if (data.pending !== "t"){
            const vehResponse = await fetch(`../../controller/admin/fetch_veh_off_id.php?off_id=${encodeURIComponent(data.off_id)}`);
            if (!vehResponse.ok) throw new Error("Failed to fetch vehicle data");
            const vehData = await vehResponse.json();
            //console.log(vehData)
            if (vehData.length > 0) {
                vehUsername = vehData[0].username;

            } else {
                vehUsername = vehData.username;
            } //console.log(vehUsername);
        }
    }catch(error){
        console.error("Error fetching offer data for popup: ", error);
    }
  return `<div>
        <b>Offer</b><br>
        <b>Ονοματεπώνυμο:</b> ${full_name}<br>
        <b>Τηλέφωνο:</b> ${phone}<br>
        <b>Ημερομηνία Καταχώρησης:</b> ${data.reg_date}<br>
        <b>Είδος:</b> ${item_name}<br>
        <b>Ποσότητα:</b> ${data.quantity}<br>
        <b>Ημερομηνία Ανάληψης:</b> ${
          data.pending !== "t" ? data.assign_date : "N/A"
        }<br>
        <b>Rescuer's Username:</b> ${data.pending !== "t" ? vehUsername : "N/A"}
        <button onclick="takeNewOffer(${data.off_id})" class="new_off_req">Do you want to take charge of this offer?</button>
    </div>
        `;
}

function takeNewOffer(id) {
    fetch(`../../controller/rescuer/take_new_offer.php?off_id=${encodeURIComponent(id)}&timestamp=${new Date().getTime()}`)
    .then(response => response.json())
    .then(data=>{
        if(data.created){
            alert('Successfully added! You are now in charge');
            location.reload();
        }else{
            alert(data.error);
        }
    })
    .catch(error => console.log(error));
}

async function requestPopupRescuer(data) {
    let full_name = "";
    let phone = "";
    let item_name = "";
    let vehUsername = "";

    try {
        const userResponse = await fetch(`../../controller/admin/fetch_user_by_id.php?user_id=${encodeURIComponent(data.user_id)}`);
        const itemResponse = await fetch(`../../controller/admin/fetch_item_by_id.php?item_id=${encodeURIComponent(data.item_id)}`);

        const userData = await userResponse.json();
        if (userData.length > 0) {
          full_name = `${userData[0].first_name} ${userData[0].surname}`;
          phone = userData[0].phone;
        }else{
            full_name = `${userData.first_name} ${userData.surname}`;
            phone = userData.phone;
        }


        if (!itemResponse.ok) throw new Error("Failed to fetch item data");
        const itemData = await itemResponse.json();
        if (itemData.length > 0) {
          item_name = itemData[0].iname;
        } else {
          item_name = itemData.iname;
        }//console.log(item_name);

        if (data.pending !== "t"){
            const vehResponse = await fetch(`../../controller/admin/fetch_loaded_veh.php?req_id=${encodeURIComponent(data.req_id)}`);
            if (!vehResponse.ok) throw new Error("Failed to fetch vehicle data");
            const vehData = await vehResponse.json();
            //console.log(vehData)
            if (vehData.length > 0) {
                vehUsername = vehData[0]['username'];
            } else {
                vehUsername = vehData.username;
            } //console.log(vehUsername);
        }
    }catch(error){
        console.error("Error fetching request data for popup: ", error);
    }
  return `<div>
        <b>Request</b><br>
        <b>Ονοματεπώνυμο:</b> ${full_name}<br>
        <b>Τηλέφωνο:</b> ${phone}<br>
        <b>Ημερομηνία Καταχώρησης:</b> ${data.reg_date}<br>
        <b>Είδος:</b> ${item_name}<br>
        <b>Ποσότητα:</b> ${data.quantity}<br>
        <b>Ημερομηνία Ανάληψης:</b> ${
          data.pending !== "t" ? data.assign_date : "N/A"
        }<br>
        <b>Rescuer's Username:</b> ${data.pending !== "t" ? vehUsername : "N/A"}
        <button onclick="takeNewRequest(${data.req_id})" class="new_off_req">Do you want to take charge of this request?</button>
    </div>
        `;
}

function takeNewRequest(id) {
    fetch(`../../controller/rescuer/take_new_request.php?req_id=${encodeURIComponent(id)}&timestamp=${new Date().getTime()}`)
    .then(response => response.json())
    .then(data=>{
        if(data.created){
            alert('Successfully added! You are now in charge');
            location.reload();
        }else{
            alert(data.error);
        }
    })
    .catch(error => console.log(error));
}

async function taskListData(id) {
    return await (await fetch(`../../controller/rescuer/tasks_for_list.php?veh_id=${encodeURIComponent(id)}&timestamp=${new Date().getTime()}`)).json();
}

async function tasksList(id, tasksTable){
    const my_tasks = await taskListData(id);
    my_tasks.offers.forEach(offer=>{
        let tr = document.createElement("tr");
        let full_name = offer.first_name + " " + offer.surname;
        tr.innerHTML = `
                <th>${full_name}</th>
                <th>${offer.phone}</th>
                <th>${offer.reg_date}</th>
                <th>${offer.iname}</th>
                <th>${offer.quantity}</th>
                <th>Offer</th>
                <button class="new_off_req" id="done-btn" onclick="finishTask(${offer.tasks_id})">Done</button>
                <button class="cancel_btn" id="done-btn" onclick="cancelTask(${offer.tasks_id},'offer')">Cancel</button
        `;
        tasksTable.appendChild(tr);
    });
    my_tasks.requests.forEach(req=>{
        let tr = document.createElement("tr");
        let full_name = req.first_name + " " + req.surname;
        tr.innerHTML = `
                <th>${full_name}</th>
                <th>${req.phone}</th>
                <th>${req.reg_date}</th>
                <th>${req.iname}</th>
                <th>${req.quantity}</th>
                <th>Request</th>
                <button class="new_off_req" id="done-btn" onclick="finishTask(${req.tasks_id})">Done</button>
                <button class="cancel_btn" id="done-btn" onclick="cancelTask(${req.tasks_id},'request')">Cancel</button
        `;
        tasksTable.appendChild(tr);
    });
}

function finishTask(id){
    fetch(`../../controller/rescuer/finish_task.php?task_id=${encodeURIComponent(id)}&timestamp=${new Date().getTime()}`)
    .then(response => response.json())
    .then(data=>{
        if(data.finished_){
            alert('Task is finished. Thank you!');
            location.reload();
        }else{
            alert(data.error);
        }
    })
    .catch(error => console.log(error));
}

function cancelTask(id, action){
     fetch(`../../controller/rescuer/cancel_task.php?task_id=${encodeURIComponent(id)}&action=${encodeURIComponent(action)}&timestamp=${new Date().getTime()}`)
    .then(response => response.json())
    .then(data=>{
        if(data.cancelled){
            alert('Succesfully removed! Now you can pick more');
            location.reload();
        }else{
            alert(data.error);
        }
    })
    .catch(error => console.log(error));
}
