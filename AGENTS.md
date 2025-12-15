# Agent Guidelines for SOP-System

These instructions apply to all work in this repository.

## Workflow Expectations
- Maintain the SOP system end-to-end until completion: keep tasks scoped, describe assumptions, and clarify any open questions in commit or PR descriptions.
- For each feature or fix, outline the intended steps before coding when non-trivial.
- Keep changes incremental and reversible; avoid large, tangled commits.

## Testing Requirements
- Add or update automated tests for every change when feasible. Document the exact commands executed.
- Run relevant test suites after modifications. If a test cannot be run (environment or time constraints), explain why and what would need to be done to run it.
- Include setup or seed steps needed for tests when they are non-obvious.

## Quality and Review
- Prefer clear, self-documenting code; add focused comments where logic is non-obvious.
- Validate inputs and handle edge cases; surface errors with actionable messages.
- If you encounter errors, revise the change to address them or describe remaining issues explicitly.

## Documentation
- Update README or in-repo docs when behavior, configuration, or workflows change.
- Keep examples runnable; include sample commands or curl snippets when adding endpoints.

## Git Hygiene
- Use descriptive commit messages summarizing the change.
- Ensure working tree is clean before invoking PR automation.

