function draw() {
    const data = {
        labels: ['2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2014'],
        datasets: [
            {
                label: 'Documents',
                data: [48,45,60,67,80,89,89,120,140,175,160,170,180,183,13],
                backgroundColor: '#362f78',
                borderColor: '#756ebd',
                borderWidth: 1,
            },
            {
                label: 'Tagged',
                data: [5,3,6,7,3,4,15,16,18,7,0,6,6,3,1],
                backgroundColor: '#1c64f2',
                borderColor: '#1c64f2',
                borderWidth: 1,
            },
        ],
    };


    new Chart(document.getElementById("barChart"), {
    type: 'bar',
    data: data,
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
});
}