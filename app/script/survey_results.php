<?php
require_once 'get_hobby_stats.php';
require_once 'get_gender_stats.php';
require_once 'get_rating_stats.php';
require_once 'get_daily_responses.php';
require_once 'get_nationality_stats.php';
require_once 'get_age_stats.php';
require_once 'get_pc_stats.php';

$hobbyStats = getHobbyStats();
$labels = array_column($hobbyStats, 'name');
$data = array_column($hobbyStats, 'count');

$genderStats = getGenderStats();
$genderLabels = array_map('ucfirst', array_column($genderStats, 'gender'));
$genderData = array_column($genderStats, 'count');

$averageRating = getAverageRating();

$dailyResponses = getDailyResponses();
$responseDates = array_column($dailyResponses, 'date');
$responseCounts = array_column($dailyResponses, 'count');

$nationalityStats = getNationalityStats();
$nationalityLabels = array_map('ucfirst', array_column($nationalityStats, 'name'));
$nationalityCounts = array_column($nationalityStats, 'count');

$ageStats = getAgeStats();
$ageLabels = array_column($ageStats, 'range');
$ageCounts = array_column($ageStats, 'count');

$pcStats = getPCStats();
$pcLabels = array_column($pcStats, 'has_pc');
$pcCounts = array_column($pcStats, 'count');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Results - Statistics</title>
    <link rel="stylesheet" href="../style/output.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
    <div class="flex flex-col items-center justify-center gap-y-4 py-10">

        <div class="flex flex-col gap-y-4">

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Survey Results Summary</h2>
            </div>

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Hobbies Distribution</h2>
                <div class="bg-white p-4 rounded-lg shadow-inner">
                    <canvas id="hobbyChart"></canvas>
                </div>
            </div>

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Gender Distribution</h2>
                <div class="bg-white p-4 rounded-lg shadow-inner">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Nationality Distribution</h2>
                <div class="bg-white p-4 rounded-lg shadow-inner">
                    <canvas id="nationalityChart"></canvas>
                </div>
            </div>

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Age Distribution</h2>
                <div class="bg-white p-4 rounded-lg shadow-inner">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Personal Computer Ownership</h2>
                <div class="bg-white p-4 rounded-lg shadow-inner">
                    <canvas id="pcChart"></canvas>
                </div>
            </div>

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Average Rating</h2>
                <div class="bg-white p-4 rounded-lg shadow-inner flex flex-col items-center">
                    <div class="text-4xl font-bold text-accent"><?php echo $averageRating; ?></div>
                    <div class="text-sm text-gray-600 mt-2">out of 5 stars</div>
                    <div class="flex items-center mt-4">
                        <?php
                        $fullStars = floor($averageRating);
                        $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
                        
                        // Full stars
                        for ($i = 0; $i < $fullStars; $i++) {
                            echo '<span class="text-2xl text-highlight">★</span>';
                        }
                        
                        // Half star
                        if ($hasHalfStar) {
                            echo '<span class="text-2xl text-highlight">★</span>';
                        }
                        
                        // Empty stars
                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                        for ($i = 0; $i < $emptyStars; $i++) {
                            echo '<span class="text-2xl text-gray-300">★</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-secondary rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-accent mb-6 text-center">Daily Response Trend</h2>
                <div class="bg-white p-4 rounded-lg shadow-inner">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <a href="../index.php"
            class="mt-16 inline-block bg-accent text-white px-12 py-2 rounded-xl hover:bg-opacity-70 transition-colors">
            Back to Survey
        </a>

    </div>
    <script>
        // Nationality Line Chart
        const nationalityCtx = document.getElementById('nationalityChart').getContext('2d');
        new Chart(nationalityCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($nationalityLabels); ?>,
                datasets: [{
                    label: 'Number of Respondents',
                    data: <?php echo json_encode($nationalityCounts); ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Daily Response Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($responseDates); ?>,
                datasets: [{
                    label: 'Number of Responses',
                    data: <?php echo json_encode($responseCounts); ?>,
                    borderColor: 'rgba(99, 102, 241, 1)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    pointStyle: false,
                    hitRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'none'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });

        // Hobby Bar Chart
        const hobbyCtx = document.getElementById('hobbyChart').getContext('2d');
        new Chart(hobbyCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Number of Respondents',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Gender Pie Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($genderLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($genderData); ?>,
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderColor: [
                        'rgba(99, 102, 241, 1)',
                        'rgba(236, 72, 153, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // Age Bar Chart
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($ageLabels); ?>,
                datasets: [{
                    label: 'Number of Respondents',
                    data: <?php echo json_encode($ageCounts); ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // PC Ownership Pie Chart
        const pcCtx = document.getElementById('pcChart').getContext('2d');
        new Chart(pcCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($pcLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($pcCounts); ?>,
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(99, 102, 241, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>

</html>