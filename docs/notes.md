## Technical Notes

### Biggest Docker Problem and Solution
The main Docker issue I faced was a port conflict error when running the container. Docker reported that port 8080 was already allocated because another container was still running. I solved this problem by listing running containers using `docker ps`, stopping the active container with `docker stop`, and then re-running the application. This helped me understand how Docker manages ports and containers.

### Most Important Git/GitHub Lesson Learned
The most important lesson I learned was that GitHub does not automatically update when files are modified locally. Changes must be staged, committed with a clear and professional commit message, and then pushed to GitHub. I also learned the importance of using meaningful commit messages and organizing commits logically throughout the project.
.
### Bonus Work
- Added docker-compose.yml to simplify running the application.
- Added a Docker healthcheck to monitor container status.

### VPS Deployment Challenges
One of the main challenges during this assignment was working with the VPS platform recommended in the assignment instructions, as the web-based terminal was not functioning properly and prevented reliable access to the server environment.

To overcome this issue, an alternative deployment platform was used based on a recommendation shared by a colleague (Ahmed Al-Khatib) through a provided instructional video. The alternative platform allowed successful deployment of the Dockerized application and provided a stable environment to complete all required deployment steps.

This experience highlighted the importance of flexibility when working with cloud platforms and reinforced the understanding of Docker-based deployments across different VPS providers.
