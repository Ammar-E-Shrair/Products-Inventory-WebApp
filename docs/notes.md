## Technical Notes

### Biggest Docker Problem and Solution
The main Docker issue I faced was a port conflict error when running the container. Docker reported that port 8080 was already allocated because another container was still running. I solved this problem by listing running containers using `docker ps`, stopping the active container with `docker stop`, and then re-running the application. This helped me understand how Docker manages ports and containers.

### Most Important Git/GitHub Lesson Learned
The most important lesson I learned was that GitHub does not automatically update when files are modified locally. Changes must be staged, committed with a clear and professional commit message, and then pushed to GitHub. I also learned the importance of using meaningful commit messages and organizing commits logically throughout the project.
### Bonus Work
- Added docker-compose.yml to simplify running the application.
- Added a Docker healthcheck to monitor container status.
